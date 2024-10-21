<?php

namespace Jdillenberger\LaravelBaseline\Models;

use Spatie\Multitenancy\Contracts\IsTenant;

class Tenant extends \Jdillenberger\LaravelBaseline\Foundation\Model implements IsTenant
{
    use \Illuminate\Database\Eloquent\Factories\HasFactory;
    use \Illuminate\Database\Eloquent\SoftDeletes;
    use \Spatie\Multitenancy\Models\Concerns\ImplementsTenant;
    use \Spatie\Multitenancy\Models\Concerns\UsesLandlordConnection;
    use \Jdillenberger\LaravelBaseline\Models\Traits\HasTags;

    protected static $policy = \Jdillenberger\LaravelBaseline\Policies\TenantPolicy::class;

    public $table = 'tenants';

    protected $fillable = [
        'name',
        'domain',
        'prefix',
        'force_port',
    ];

    protected $appends = [
        'url',
    ];

    protected $hidden = [
        'deleted_at',
    ];

    public function getUrlAttribute()
    {
        return $this->url();
    }

    public function url()
    {

        $domain = $this->domain ?? config('app.url');
        $port = $this->force_port ?? config('app.port') ?? 443;
        $pathPrefix = $this->prefix ? '/'.$this->prefix : '';
        $pathApi = '/api';

        $portString = in_array($port, [80, 443]) ? '' : ":$port";

        if (\Illuminate\Support\Str::startsWith($domain, 'http')) {
            return url("{$domain}{$portString}{$pathPrefix}{$pathApi}");
        }

        $schema = ($port === 443) ? 'https://' : 'http://';

        return url("{$schema}{$domain}{$portString}{$pathPrefix}{$pathApi}");
    }

    public function users()
    {
        return $this->belongsToMany(getBaselineUserModel(), 'tenant_user', 'tenant_id', 'user_id');
    }
}
