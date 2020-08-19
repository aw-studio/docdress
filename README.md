# Docdress

A package to create markdown documentations from GitHub repositories in your
Laravel project.

![Docdress](screen.png 'Docdress')

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
-   [Alerts](#alerts)

<a name="introduction"></a>

## Introduction

<a name="setup"></a>

## Setup

Install **Docdress** via composer:

```shell
composer require aw-studio/docdress
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

![webhook-url](webhook-url.png 'Webhook Url')

Additionally the **Content-Type** must be set to `application/json`.

![webhook-content-type](webhook-content-type.png 'Webhook Content Type')

And the `token` from your config must be specified.

```php
'repos' => [

    'my/repo' => [
        // ...

        'webhook_token' => env('GITHUB_WEBHOOK_TOKEN', null),
    ],

],
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

![alert-tip](alert-tip.png 'Alert Tip')
![alert-warning](alert-warning.png 'Alert Warning')
![alert-danger](alert-danger.png 'Alert Danger')
