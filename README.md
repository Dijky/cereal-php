# Cereal PHP

This library implements the functionality of the C++ serialization library
[Cereal](http://uscilab.github.io/cereal/) in pure PHP.

It intends to create a compatible serialization feature to enable data exchange
between C++ and PHP applications.

## Installation

Use Composer to install this library:

    composer require dijky/cereal-php

## Requirements and Limitations

- Cereal PHP requires a 64 bit installation of PHP 7.0 or higher
- PHP does not support unsigned 64 bit integers; all uses of `Integral\UInt64` are therefore effectively limited to 63 bits.  
This includes the `SizeTag` for `Vector` size and `Str` length.

## License

Cereal PHP is licensed under the permissive MIT license which allows usage in
all free and commercial contexts.  
You can find the full license text in the [license file](https://github.com/Dijky/cereal-php/blob/master/LICENSE).
