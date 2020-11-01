# Docdress

A package to create markdown documentations from GitHub repositories in your
Laravel project. Easy editing for contributors.

![Docdress](screens/screen.png 'Docdress')

The example image shows the [litstack documenation](https://litstack.io/docs).
The GitHub repository can be found under
[litstack/litstack.io](https://github.com/litstack/litstack.io).

## Table Of Contents

-   [Introduction](#introduction)
-   [Setup](#setup)
    -   [Add repository to Config](#add-repository-to-config)
    -   [Clone repository](#clone-repository)
-   [Structure](#structure)
    -   [Readme.md](#readme-me)
    -   [Table of Contents](#toc)
-   [Configuration](#configuration)
    -   [Versions](#versions)
    -   [Private repositories](#private-repositories)
    -   [Webhook](#webhook)
    -   [Algolia](#algolia)
-   [Authorization](#authorization)
-   [Alerts](#alerts)
-   [Search Component](#search-component)
-   [Testing](#testing)

<a name="introduction"></a>

## Introduction

With Docdress you can turn your project/package documentation within minutes
into a web interface with a Laravel-like design.

Docdress offers the following features:

-   Laravel-like design
-   Documentation for private repositories
-   Documentation from subfolders of repositories
-   Automatically updated by webhooks
-   Any number of repositories in a Laravel project
-   Custom themes
-   Authentication

<a name="setup"></a>

## Setup

Install **Docdress** via composer:

```shell
composer require aw-studio/docdress
```

Now publish the required assets and the config:

```shell
php artisan vendor:publish --provider="Docdress\DocdressServiceProvider"
```

You may also publish the `config` or `assets`only like this:

```shell
php artisan vendor:publish --tag="docdress:assets"
php artisan vendor:publish --tag="docdress:config"
```

<a name="add-repository-to-config"></a>

### Add repository to Config

Add the desired repository to the `docdress` config.

```php
'repos' => [
    'my/repo' => [
        //
    ],
],
```

<a name="clone-repository"></a>

### Clone repository

Once you have configured the repository, you must clone it using
`docdress:clone`:

```shell
php artisan docdress:clone `my/repo`
```

<a name="structure"></a>

## Structure

<a name="readme-me"></a>

### Readme.md

The index is built as a nested list in the `readme.md`. It is located under
`## Index`. So your `readme.md` could look like this:

```markdown
# My Package

Hello World.

## Index

-   ## Getting Started
    -   [Introduction](introduction.md)
    -   [Installation](installation.md)
-   ## Foo
    -   [Bar](subfolder/bar.md)
```

<a name="toc"></a>

## Table of Contents

The table of contents is built from all `##` and `###` headings under the `#`
heading. No link tag with a `name`attribute is needed. You can easily build your
markdown file as follows:

```markdown
# Title

## Introduction

...
```

<a name="configuration"></a>

## Configuration

With **Docdress** any number of repositories can be documented in one laravel
project. Each repository is configured in `docdress.repos` like so:

```php
'repos' => [
    'my/repo' => [
        // ...
    ],
],
```

The following attributes can be configured for a repository:

-   `route_prefix` - The route prefix under which the documentation is
    accessible.
-   `default_page` - The default page
-   `versions` - An array containing the branches that should be available in
    the documentation.
-   `default_version` - The current version.
-   `subfolder` - The subfolder of the documentation.
-   `theme` - The theme that should be used for this repo. Default value:
    `default`.
-   `access_token` - Personal access token for private repositories.
-   `webhook_token` - Webhook token to allow pulling the repository after a
    change.

Some of the attributes are discussed in more detail below:

<a name="versions"></a>

### Versions

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

<a name="private-repositories"></a>

### Private repositories

Private repositories require a
[personal access token](https://github.com/settings/tokens) with the read
permissions for the repository.

```php
'repos' => [

    'my/repo' => [
        // ...
        'access_token' => env('GITHUB_ACCESS_TOKEN', null)
    ],

],
```

<a name="subfolder"></a>

### Subfolder

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

<a name="webhook"></a>

### Webhook

If you want the latest version to be automatically updated with every push, you
have to set a webhook with the url `_docdress/update`.

![webhook-url](screens/webhook-url.png 'Webhook Url')

Additionally the **Content-Type** must be set to `application/json`.

![webhook-content-type](screens/webhook-content-type.png 'Webhook Content Type')

And the `token` from your config must be specified.

```php
'repos' => [

    'my/repo' => [
        // ...

        'webhook_token' => env('GITHUB_WEBHOOK_TOKEN', null),
    ],

],
```

<a name="algolia"></a>

### Algolia

![Docdress Search](screens/search.png 'Docdress Search')

[Algolia Docsearch](https://docsearch.algolia.com/) can be used for the search
of your documenation. All you have to do is to specify your **application key**
for the respective repository.

```php
'repos' => [

    'my/repo' => [
        // ...

        'algolia_app_key' => env('ALGOLIA_APP_KEY', null),
    ],

],
```

<a name="authorization">

## Authorization

You may create gate for a repository in the `boot` method of your
`AuthServiceProvider` to manage access to the documentation.

```php
use Docdress\Docdress;

public function boot()
{
    $this->registerPolicies();

    Docdress::gate('my/repo', function ($user) {
        return $user->is_admin;
    });
}
```

<a name="alerts">

## Alerts

You may display alerts just like custom-blocks in vuepress. The available alert
types are `tip`, `warning`, `danger`

```markdown
::: tip

Hello World!

:::
```

```markdown
::: warning

Hello World!

:::
```

```markdown
::: danger

Hello World!

:::
```

![alert-tip](screens/alert-tip.png 'Alert Tip')
![alert-warning](screens/alert-warning.png 'Alert Warning')
![alert-danger](screens/alert-danger.png 'Alert Danger')

<a name="search-component">

## Search Component

By using the `x-dd-search-input` component. You can place the algolia search
input in your blade views. The component needs the `repo` that should be
searched and the desired version.

```html
<x-dd-search-input repo="my/repo" version="1.0" />
```

<a name="testing">

## Testing

Execute tests via composer:

```shell
composer test
```
