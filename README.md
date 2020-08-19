# Docdress

A package to deploy markdown documentations from GitHub repositories to your
Laravel site.

## Setup

The package gets installed.

## Subfolder

You may have the documentation of a project or a package in a subfolder of the
corresponding repository. If a `subfolder` is specified in the config, only this
folder is cloned and displayed.

```php
'repos' => [

    'my/repo' => [
        // ...

        'subfolder' => 'docs'
    ],

],
```

## Webhook

If you want the latest version to be automatically updated with every push, you
have to set a webhook with the url `_docdress/update`. Additionally the
**Content-Type** must be set to `application/json` and the token from your
config must be specified.
