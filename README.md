[![GitHub license](https://img.shields.io/github/license/fawno/IPAuthenticator)](https://github.com/fawno/IPAuthenticator/blob/master/LICENSE)
[![GitHub tag (latest SemVer)](https://img.shields.io/github/v/tag/fawno/IPAuthenticator.svg)](https://github.com/fawno/IPAuthenticator/tags)
[![Packagist](https://img.shields.io/packagist/v/fawno/ip-authentication)](https://packagist.org/packages/fawno/ip-authentication)
[![Packagist Downloads](https://img.shields.io/packagist/dt/fawno/ip-authentication)](https://packagist.org/packages/fawno/ip-authentication/stats)
[![GitHub issues](https://img.shields.io/github/issues/fawno/IPAuthenticator)](https://github.com/fawno/IPAuthenticator/issues)
[![GitHub forks](https://img.shields.io/github/forks/fawno/IPAuthenticator)](https://github.com/fawno/IPAuthenticator/network)
[![GitHub stars](https://img.shields.io/github/stars/fawno/IPAuthenticator)](https://github.com/fawno/IPAuthenticator/stargazers)

# IP Authenticator for CakePHP 4 Authentication plugin

This plugin provides an IP Authenticator for CakePHP 4 authentication plugin.

# Table of contents
- [Requirements](#requirements)
- [Installation](#installation)

## Requirements

- PHP >= 7.2.0
- CakePHP >= 4.3.0
- [CakePHP Authentication](https://book.cakephp.org/authentication/2/en/index.html) >= 2.0


[TOC](#table-of-contents)

## Installation

Install this plugin into your application using [composer](https://getcomposer.org):

- Add `fawno/ip-authentication` package to your project:
  ```bash
    composer require fawno/ip-authentication
  ```
- Load the IPAuthenticator in your `Application.php`:
  ```php
  use IPAuthenticator\Authenticator\IPAuthenticator;
  ```
- Load the IPAuthenticator in your Authentication Service (`Application.php`):
  ```php
  // Load the authenticators. Session should be first.
  $service->loadAuthenticator('Authentication.Session');

  $service->loadAuthenticator(IPAuthenticator::class, [
      'auth' => [
          '127.0.0.1' => [
              'username' => 'localhost',
              'displayname' => 'Local Host',
              'dn' => [],
              'memberof' => [
                  'Group' => 'Group',
              ],
          ],
      ],
  ]);
  ```

[TOC](#table-of-contents)

