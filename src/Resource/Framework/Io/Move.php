<?php

/**
 * apparat-resource
 *
 * @category    Apparat
 * @package     Apparat_<Package>
 * @author      Joschi Kuphal <joschi@kuphal.net> / @jkphl
 * @copyright   Copyright © 2015 Joschi Kuphal <joschi@kuphal.net> / @jkphl
 * @license     http://opensource.org/licenses/MIT	The MIT License (MIT)
 */

/***********************************************************************************
 *  The MIT License (MIT)
 *
 *  Copyright © 2015 Joschi Kuphal <joschi@kuphal.net> / @jkphl
 *
 *  Permission is hereby granted, free of charge, to any person obtaining a copy of
 *  this software and associated documentation files (the "Software"), to deal in
 *  the Software without restriction, including without limitation the rights to
 *  use, copy, modify, merge, publish, distribute, sublicense, and/or sell copies of
 *  the Software, and to permit persons to whom the Software is furnished to do so,
 *  subject to the following conditions:
 *
 *  The above copyright notice and this permission notice shall be included in all
 *  copies or substantial portions of the Software.
 *
 *  THE SOFTWARE IS PROVIDED "AS IS", WITHOUT WARRANTY OF ANY KIND, EXPRESS OR
 *  IMPLIED, INCLUDING BUT NOT LIMITED TO THE WARRANTIES OF MERCHANTABILITY, FITNESS
 *  FOR A PARTICULAR PURPOSE AND NONINFRINGEMENT. IN NO EVENT SHALL THE AUTHORS OR
 *  COPYRIGHT HOLDERS BE LIABLE FOR ANY CLAIM, DAMAGES OR OTHER LIABILITY, WHETHER
 *  IN AN ACTION OF CONTRACT, TORT OR OTHERWISE, ARISING FROM, OUT OF OR IN
 *  CONNECTION WITH THE SOFTWARE OR THE USE OR OTHER DEALINGS IN THE SOFTWARE.
 ***********************************************************************************/

namespace Apparat\Resource\Framework\Io;

use Apparat\Resource\Framework\Io\File\Reader as FileReader;
use Apparat\Resource\Framework\Io\File\Writer as FileWriter;
use Apparat\Resource\Framework\Io\InMemory\Writer as InMemoryWriter;
use Apparat\Resource\Model\Writer;

/**
 * Resource move operation
 *
 * @package Apparat\Resource\Framework\Io
 */
class Move extends IoHandler
{
	/*******************************************************************************
	 * PUBLIC METHODS
	 *******************************************************************************/

	/**
	 * Move / rename the source resource to a target resource
	 *
	 * @param string $target Stream wrapped target
	 * @param array $parameters Writer parameters
	 * @return Writer Writer instance
	 * @throws InvalidArgumentException If the writer stream wrapper is invalid
	 */
	public function to($target, ...$parameters)
	{
		$writer = Io::writer($target, $parameters);

		// If it's a file writer
		if ($writer instanceof FileWriter) {
			return $this->_moveToFile($writer);
		}

		// If it's an in-memory writer
		if ($writer instanceof InMemoryWriter) {
			return $this->_moveToInMemory($writer);
		}

		throw new InvalidArgumentException('Invalid writer stream wrapper',
			InvalidArgumentException::INVALID_WRITER_STREAM_WRAPPER);
	}

	/*******************************************************************************
	 * PRIVATE METHODS
	 *******************************************************************************/

	/**
	 * Move / rename the resource to a file
	 *
	 * @param FileWriter $writer Target file writer
	 * @return FileWriter File writer instance
	 * @throws RuntimeException If the resource cannot be moved / renamed
	 */
	protected function _moveToFile(FileWriter $writer)
	{
		// If a file resource is read
		if ($this->_reader instanceof FileReader) {

			// If a copy error occurs
			if (!@rename($this->_reader->getFile(), $writer->getFile())) {
				throw new RuntimeException(sprintf('Could not move / rename "%s" to "%s"', $this->_reader->getFile(),
					$writer->getFile()), RuntimeException::COULD_NOT_MOVE_FILE_TO_FILE);
			}

			// Else: In-memory resource
		} else {
			$writer->write($this->_reader->read());
		}

		return $writer;
	}

	/**
	 * Move / rename the resource to a in-memory buffer
	 *
	 * @param InMemoryWriter $writer Target in-memory writer
	 * @return InMemoryWriter In-memory writer instance
	 */
	protected function _moveToInMemory(InMemoryWriter $writer)
	{
		$writer->write($this->_reader->read());
		return $writer;
	}
}