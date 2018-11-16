# Change Log


All notable changes to this project will be documented in this file.

The format is based on [Keep a Changelog](http://keepachangelog.com/en/1.0.0/)
and this project adheres to [Semantic Versioning](http://semver.org/spec/v2.0.0.html).


## [Unreleased]

### Changed
- Function `sendRequest` of `\Http\Adapter\Guzzle6\Client` used to throw a `\UnexpectedValueException`. Now it throws a 
`Http\Adapter\Guzzle6\Exception\UnexpectedValueException` that extends the `\UnexpectedValueException` and implements
the `Psr\Http\Client\ClientExceptionInterface`. This is done in order to be PSR-18 compliant.

- Function `sendRequest` of `\Http\Adapter\Guzzle6\Client` used to throw a `\RuntimeException`. Now it throws a 
`Http\Client\Exception\TransferException` that extends the `\RuntimeException` and implements
the `Psr\Http\Client\ClientExceptionInterface`. This is done in order to be PSR-18 compliant.

## [2.0.0] - 2018-11-14

### Added

- Support for HTTPlug 2.0 and PSR-18

### Changed

- `Client` and `Promise` are both final

### Removed

- Support for PHP <7.1


## [1.1.1] - 2016-05-10

### Fixed

- Adapter can again be instantiated without a guzzle client.


## [1.1.0] - 2016-05-09

### Added

- Factory method Client::createWithConfig to create an adapter with custom
  configuration for the underlying guzzle client.


## [1.0.0] - 2016-01-26


## [0.4.1] - 2016-01-13

### Changed

- Updated integration tests

### Removed

- Client common dependency


## [0.4.0] - 2016-01-12

### Changed

- Updated package files
- Updated HTTPlug to RC1


## [0.3.1] - 2015-12-31


## [0.3.0] - 2015-12-31


## [0.2.1] - 2015-12-17

### Added

- Puli configuration and bindings

### Changed

- Guzzle setup conforms to HTTPlug requirement now: Minimal functionality in client


## [0.2.0] - 2015-12-15

### Added

- Async client capabalities

### Changed

- HTTPlug instead of HTTP Adapter


## 0.1.0 - 2015-06-12

### Added

- Initial release


[Unreleased]: https://github.com/php-http/guzzle6-adapter/compare/v2.0.0...HEAD
[2.0.0]: https://github.com/php-http/guzzle6-adapter/compare/v1.1.1...v2.0.0
[1.1.1]: https://github.com/php-http/guzzle6-adapter/compare/v1.1.0...v1.1.1
[1.1.0]: https://github.com/php-http/guzzle6-adapter/compare/v1.0.0...v1.1.0
[1.0.0]: https://github.com/php-http/guzzle6-adapter/compare/v0.4.1...v1.0.0
[0.4.1]: https://github.com/php-http/guzzle6-adapter/compare/v0.4.0...v0.4.1
[0.4.0]: https://github.com/php-http/guzzle6-adapter/compare/v0.2.1...v0.4.0
[0.3.1]: https://github.com/php-http/guzzle6-adapter/compare/v0.3.0...v0.3.1
[0.3.0]: https://github.com/php-http/guzzle6-adapter/compare/v0.2.1...v0.3.0
[0.2.1]: https://github.com/php-http/guzzle6-adapter/compare/v0.2.0...v0.2.1
[0.2.0]: https://github.com/php-http/guzzle6-adapter/compare/v0.1.0...v0.2.0
