<?php

/**
 * This file is part of Packagist Stats by Graham Campbell.
 *
 * THE SOFTWARE IS PROVIDED "AS IS", WITHOUT WARRANTY OF ANY KIND, EXPRESS OR
 * IMPLIED, INCLUDING BUT NOT LIMITED TO THE WARRANTIES OF MERCHANTABILITY,
 * FITNESS FOR A PARTICULAR PURPOSE AND NONINFRINGEMENT. IN NO EVENT SHALL THE
 * AUTHORS OR COPYRIGHT HOLDERS BE LIABLE FOR ANY CLAIM, DAMAGES OR OTHER
 * LIABILITY, WHETHER IN AN ACTION OF CONTRACT, TORT OR OTHERWISE, ARISING FROM,
 * OUT OF OR IN CONNECTION WITH THE SOFTWARE OR THE USE OR OTHER DEALINGS IN
 * THE SOFTWARE.
 */

namespace GrahamCampbell\PackagistStats;

use Packagist\Api\Client as Packagist;

/**
 * This is the client class.
 *
 * @author    Graham Campbell <graham@cachethq.io>
 * @copyright 2014 Graham Campbell
 * @license   <https://github.com/GrahamCampbell/Packagist-Stats/blob/master/LICENSE.md> MIT
 */
class Client
{
    /**
     * The packagist client instance.
     *
     * @var \Packagist\Api\Client
     */
    protected $packagist;

    /**
     * Create a new client instance.
     *
     * @param \Packagist\Api\Client $packagist
     *
     * @return void
     */
    public function __construct(Packagist $packagist)
    {
        $this->packagist = $packagist;
    }

    /**
     * Get the aggregated information from packagist.
     *
     * Please pass an array of vendors or package names, or a single vendor or
     * package name to this method.
     *
     * @param string[]|string $vendors
     *
     * @return array
     */
    public function packages($vendors)
    {
        $packages = [];

        foreach ((array) $vendors as $vendor) {
            if (strpos($vendor, '/') !== false) {
                $packages[] = $this->packagist->get($vendor);
            } else {
                foreach ($this->packagist->all(compact('vendor')) as $result) {
                    $packages[] = $this->packagist->get($result);
                }
            }
        }

        return $packages;
    }

    /**
     * Get the packagist client instance.
     *
     * @return \Packagist\Api\Client
     */
    public function getPackagistClient()
    {
        return $this->packagist;
    }
}
