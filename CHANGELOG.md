# Changelog
All notable changes to this project will be documented in this file.

The format is based on [Keep a Changelog](https://keepachangelog.com/en/1.0.0/),
and this project adheres to [Semantic Versioning](https://semver.org/spec/v2.0.0.html).

## [Unreleased]

## [v2.0.1] - 2022-09-25
### Changed
- Check status by group instead of the bank

## [v2.0.0] - 2022-09-23
### Changed
- The version of the kevin API was updated to 0.3
- Added option to pass payment method by credit card

## [v1.1.0] - 2021-07-21
### Added
- New method `getPaymentGroup` in `FetchTransactionResponse`
- New method `isPaymentCompleted` in `FetchTransactionResponse`

## [v1.0.0] - 2021-04-02
### Changed
- Method `makeResponse` now requires third parameter `$reasonPhrase`
- Method `getValueFromData` now can search recursive to array by providing dotted key

## [v0.1.0-RC] - 2021-03-24
### Added
- Release v0.1.0-RC

[Unreleased]: https://github.com/DeH4eG/omnipay-kevin/compare/v2.0.1...HEAD
[v2.0.1]: https://github.com/DeH4eG/omnipay-kevin/releases/tag/v2.0.1
[v2.0.0]: https://github.com/DeH4eG/omnipay-kevin/releases/tag/v2.0.0
[v1.1.0]: https://github.com/DeH4eG/omnipay-kevin/releases/tag/v1.1.0
[v1.0.0]: https://github.com/DeH4eG/omnipay-kevin/releases/tag/v1.0.0
[v0.1.0-RC]: https://github.com/DeH4eG/omnipay-kevin/releases/tag/v0.1.0-RC
