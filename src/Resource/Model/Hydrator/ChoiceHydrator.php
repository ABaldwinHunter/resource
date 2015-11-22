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

namespace Apparat\Resource\Model\Hydrator;

use Apparat\Resource\Model\Part\Part;
use Apparat\Resource\Model\Part\PartChoice;

/**
 * Abstract choice hydrator
 *
 * @package Apparat\Resource\Model\Hydrator
 */
abstract class ChoiceHydrator extends MultipartHydrator
{
    /**
     * Part aggregate class name
     *
     * @var string
     */
    protected $_aggregateClass = PartChoice::class;

    /**
     * Dehydrate a single occurrence
     *
     * @param array $occurrence Occurrence
     * @return mixed Dehydrated occurrence
     * @throws RuntimeException If the occurrence is invalid
     * @throws RuntimeException If a part name doesn't match a known subhydrator
     * @throws RuntimeException If a part is invalid
     */
    protected function _dehydrateOccurrence(array $occurrence)
    {
        // If the occurrence is invalid
        if (!count($occurrence)) {
            throw new $this->_occurrenceDehydrationException('Empty occurrence', constant($this->_occurrenceDehydrationException.'::EMPTY_OCCURRENCE'));
        }

        // If the part name doesn't match a known subhydrator
        reset($occurrence);
        $subhydrator = key($occurrence);
        if (!strlen($subhydrator) || !array_key_exists($subhydrator, $this->_subhydrators)) {
            throw new $this->_occurrenceDehydrationException(sprintf('No matching subhydrator "%s"', $subhydrator), constant($this->_occurrenceDehydrationException.'::NO_MATCHING_SUBHYDRATOR'));
        }

        // If the part value is not a valid part instance
        $part = current($occurrence);
        if (!$part || !($part instanceof Part)) {
            throw new $this->_occurrenceDehydrationException(sprintf('Invalid part instance "%s"', gettype($part).(is_object($part) ? '<'.get_class($part).'>' : '')), constant($this->_occurrenceDehydrationException.'::INVALID_PART_INSTANCE'));
        }

        return $this->_dehydratePart($subhydrator, $part);
    }
}