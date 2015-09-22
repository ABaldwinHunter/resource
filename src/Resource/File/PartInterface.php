<?php

/**
 * bauwerk-resource
 *
 * @category    Jkphl
 * @package     Jkphl_Bauwerk
 * @author      Joschi Kuphal <joschi@kuphal.net> / @jkphl
 * @copyright   Copyright � 2015 Joschi Kuphal <joschi@kuphal.net> / @jkphl
 * @license     http://opensource.org/licenses/MIT	The MIT License (MIT)
 */

/***********************************************************************************
 *  The MIT License (MIT)
 *
 *  Copyright � 2015 Joschi Kuphal <joschi@kuphal.net> / @jkphl
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

namespace Bauwerk\Resource\File;

use Bauwerk\Resource\FileInterface;

/**
 * Abstract file part interface
 *
 * @package Bauwerk\Resource\File
 */
interface PartInterface
{
    /**
     * Default part name
     *
     * @var string
     */
    const DEFAULT_NAME = 'default';

    /**
     * Return the part contents as string
     *
     * @return string                       Part contents
     */
    public function __toString();

    /**
     * Parse a content string and bring the part model to live
     *
     * @param string $content               Content string
     * @return PartInterface                Self reference
     */
    public function parse($content);

    /**
     * Reset the part to its default state
     *
     * @return PartInterface                Self reference
     */
    public function reset();

    /**
     * Return the MIME type
     *
     * @return string                       MIME type
     */
    public function getMimeType();

    /**
     * Set the MIME type
     *
     * @param string $mimeType              MIME type
     * @return PartInterface                Self reference
     */
    public function setMimeType($mimeType);

    /**
     * Return the owner file
     *
     * @return FileInterface                Owner file
     */
    public function getOwnerFile();

    /**
     * Set the owner file
     *
     * @param FileInterface $ownerFile      Owner file
     * @return PartInterface                Self reference
     */
    public function setOwnerFile(FileInterface $ownerFile);

    /**
     * Return the parent part
     *
     * @return PartInterface                Parent part
     */
    public function getParentPart();

    /**
     * Set the parent part
     *
     * @param PartInterface $part           Parent part
     * @return PartInterface                Self reference
     */
    public function setParentPart(PartInterface $part);
}