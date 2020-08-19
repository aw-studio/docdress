# Docdress

A package to create markdown documentations from GitHub repositories in your
Laravel project.

![Docdress](screen.png 'Docdress')

## Setup

Install **Docdress** via composer:

```shell
composer require aw-studio/docdress
```

## Versions

Every version is representing a branch. Set the `default_version` to your
default branch. The versions are specified as branch name and title, like so:

```php
'repos' => [

    'my/repo' => [
        // ...

        'default_version' => 'master',
        'versions'        => [
            'master' => 'Master',
            '1.0'    => '1.0'
        ]'
    ],

],
```

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
have to set a webhook with the url `_docdress/update`.

![webhook-url](webhook-url.png 'Webhook Url')

Additionally the **Content-Type** must be set to `application/json` and the
token from your config must be specified.

![webhook-content-type](webhook-content-type.png 'Webhook Content Type')
