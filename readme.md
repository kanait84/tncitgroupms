<p><img src="https://laravel.com/assets/img/components/logo-laravel.svg" /></p>

<p><span style="font-size:36px"><strong>&nbsp;ABBC FOUNDATION ERP SYSTEM</strong></span></p>

<p><img src="https://ckeditor.com/apps/ckfinder/userfiles/files/image(3).png" style="height:788px; width:1303px" /></p>

<p>&nbsp;</p>

<p><span style="font-size:28px"><strong>Admin management</strong></span></p>

<p><span style="font-size:28px"><strong>Customer management</strong></span></p>

<p><span style="font-size:28px"><strong>Lead management</strong></span></p>

<p>&nbsp;</p>

<p>&nbsp;</p>

<p>&nbsp;</p>

<pre>
{
    &quot;name&quot;: &quot;bottelet/flarepoint&quot;,
    &quot;description&quot;: &quot;Flarepoint is a free, open-source and self-hosted CRM platform based of Laravel 5&quot;,
    &quot;keywords&quot;: [
        &quot;laravel&quot;,
        &quot;CRM&quot;,
        &quot;customer management&quot;,
        &quot;Lead management&quot;,
        &quot;customer relationship management&quot;
    ],
    &quot;authors&quot;: [
        {
            &quot;name&quot;: &quot;Casper Bottelet&quot;,
            &quot;email&quot;: &quot;cbottelet@gmail.com&quot;
        }
    ],
    &quot;license&quot;: &quot;MIT&quot;,
    &quot;type&quot;: &quot;project&quot;,
    &quot;require&quot;: {
        &quot;php&quot;: &quot;^7.4|^8.0&quot;,
        &quot;laravel/framework&quot;: &quot;5.4.*&quot;,
        &quot;laravelcollective/html&quot;: &quot;5.4.*@dev&quot;,
        &quot;yajra/laravel-datatables-oracle&quot;: &quot;~6.0&quot;,
        &quot;guzzlehttp/guzzle&quot;: &quot;^6.2&quot;,
        &quot;pusher/pusher-php-server&quot;: &quot;^2.3&quot;,
        &quot;zizaco/entrust&quot;: &quot;1.7.*&quot;,
        &quot;laravel/tinker&quot;: &quot;^1.0&quot;,
        &quot;laravel/dusk&quot;: &quot;^1.0&quot;,
        &quot;creativeorange/gravatar&quot;: &quot;~1.0&quot;,
        &quot;michelf/php-markdown&quot;: &quot;^1.8&quot;,
        &quot;maatwebsite/excel&quot;: &quot;~2.1.0&quot;
    },
    &quot;require-dev&quot;: {
        &quot;fakerphp/faker&quot;: &quot;^1.9.1&quot;,
        &quot;mockery/mockery&quot;: &quot;0.9.*&quot;,
        &quot;phpunit/phpunit&quot;: &quot;^9.3&quot;,
        &quot;symfony/css-selector&quot;: &quot;2.8.*|3.0.*&quot;,
        &quot;symfony/dom-crawler&quot;: &quot;2.8.*|3.0.*&quot;
    },
    &quot;autoload&quot;: {
        &quot;classmap&quot;: [
            &quot;database&quot;
        ],
        &quot;psr-4&quot;: {
            &quot;App\\&quot;: &quot;app/&quot;,
            &quot;Tests\\&quot;: &quot;tests/&quot;
        }
    },
    &quot;autoload-dev&quot;: {
        &quot;classmap&quot;: [
        ]
    },
    &quot;scripts&quot;: {
        &quot;post-root-package-install&quot;: [
            &quot;php -r \&quot;copy(&#39;.env.example&#39;, &#39;.env&#39;);\&quot;&quot;
        ],
        &quot;post-create-project-cmd&quot;: [
            &quot;php artisan key:generate&quot;
        ],
        &quot;post-install-cmd&quot;: [
            &quot;php artisan clear-compiled&quot;,
            &quot;php artisan optimize&quot;
        ],
        &quot;pre-update-cmd&quot;: [
            &quot;php artisan clear-compiled&quot;
        ],
        &quot;post-update-cmd&quot;: [
            &quot;php artisan optimize&quot;
        ]
    },
    &quot;config&quot;: {
        &quot;preferred-install&quot;: &quot;dist&quot;,
        &quot;allow-plugins&quot;: {
            &quot;kylekatarnls/update-helper&quot;: true
        }
    }
}
</pre>

<p>&nbsp;</p>

<p>&nbsp;</p>

<p>&nbsp;</p>

<p>&nbsp;</p>
