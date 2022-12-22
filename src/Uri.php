<?php
/*
Copyright (c) 2017 Jorge Matricali <jorgematricali@gmail.com>

Permission is hereby granted, free of charge, to any person obtaining a copy
of this software and associated documentation files (the "Software"), to deal
in the Software without restriction, including without limitation the rights
to use, copy, modify, merge, publish, distribute, sublicense, and/or sell
copies of the Software, and to permit persons to whom the Software is
furnished to do so, subject to the following conditions:

The above copyright notice and this permission notice shall be included in
all copies or substantial portions of the Software.

THE SOFTWARE IS PROVIDED "AS IS", WITHOUT WARRANTY OF ANY KIND, EXPRESS OR
IMPLIED, INCLUDING BUT NOT LIMITED TO THE WARRANTIES OF MERCHANTABILITY,
FITNESS FOR A PARTICULAR PURPOSE AND NONINFRINGEMENT. IN NO EVENT SHALL THE
AUTHORS OR COPYRIGHT HOLDERS BE LIABLE FOR ANY CLAIM, DAMAGES OR OTHER
LIABILITY, WHETHER IN AN ACTION OF CONTRACT, TORT OR OTHERWISE, ARISING FROM,
OUT OF OR IN CONNECTION WITH THE SOFTWARE OR THE USE OR OTHER DEALINGS IN
THE SOFTWARE.
*/

namespace Matricali\Http;

use Psr\Http\Message\UriInterface;

/**
 * Value object representing a URI.
 *
 * This interface is meant to represent URIs according to RFC 3986 and to
 * provide methods for most common operations. Additional functionality for
 * working with URIs can be provided on top of the interface or externally.
 * Its primary use is for HTTP requests, but may also be used in other
 * contexts.
 *
 * Instances of this interface are considered immutable; all methods that
 * might change state MUST be implemented such that they retain the internal
 * state of the current instance and return an instance that contains the
 * changed state.
 *
 * Typically the Host header will be also be present in the request message.
 * For server-side requests, the scheme will typically be discoverable in the
 * server parameters.
 *
 * @see http://tools.ietf.org/html/rfc3986 (the URI specification)
 */
class Uri implements UriInterface
{
    protected $scheme = '';
    protected $host = '';
    protected $port;
    protected $user = '';
    protected $pass = '';
    protected $path = '';
    protected $query = '';
    protected $fragment = '';

    public function __construct($url = '')
    {
        if (!is_array($url)) {
            $url = parse_url($url);
        }

        if (!empty($url['scheme'])) {
            $this->scheme = $url['scheme'];
        }

        if (!empty($url['host'])) {
            $this->host = $url['host'];
        }

        if (!empty($url['port'])) {
            $this->port = $url['port'];
        }

        if (!empty($url['user'])) {
            $this->user = $url['user'];
        }

        if (!empty($url['pass'])) {
            $this->pass = $url['pass'];
        }

        if (!empty($url['path'])) {
            $this->path = $url['path'];
        }

        if (!empty($url['query'])) {
            $this->query = $url['query'];
        }

        if (!empty($url['fragment'])) {
            $this->fragment = $url['fragment'];
        }
    }

    /**
     * __clone.
     *
     * @return Uri
     */
    public function __clone()
    {
        return new self();
    }

    /**
     * Return the string representation as a URI reference.
     *
     * Depending on which components of the URI are present, the resulting
     * string is either a full URI or relative reference according to RFC 3986,
     * Section 4.1. The method concatenates the various components of the URI,
     * using the appropriate delimiters:
     *
     * - If a scheme is present, it MUST be suffixed by ":".
     * - If an authority is present, it MUST be prefixed by "//".
     * - The path can be concatenated without delimiters. But there are two
     *   cases where the path has to be adjusted to make the URI reference
     *   valid as PHP does not allow to throw an exception in __toString():
     *     - If the path is rootless and an authority is present, the path MUST
     *       be prefixed by "/".
     *     - If the path is starting with more than one "/" and no authority is
     *       present, the starting slashes MUST be reduced to one.
     * - If a query is present, it MUST be prefixed by "?".
     * - If a fragment is present, it MUST be prefixed by "#".
     *
     * @see http://tools.ietf.org/html/rfc3986#section-4.1
     *
     * @return string
     */
    public function __toString()
    {
        $ret = '';
        if (!empty($this->scheme)) {
            $ret .= $this->scheme.':';
        }

        $authority = $this->getAuthority();
        if (!empty($authority)) {
            $ret .= '//'.$authority;
        }

        if (!empty($this->path)) {
            $ret .= $this->path;
        }

        if (!empty($this->query)) {
            $ret .= '?'.$this->query;
        }

        if (!empty($this->fragment)) {
            $ret .= '#'.$this->fragment;
        }

        return $ret;
    }

    /**
     * Retrieve the scheme component of the URI.
     *
     * If no scheme is present, this method MUST return an empty string.
     *
     * The value returned MUST be normalized to lowercase, per RFC 3986
     * Section 3.1.
     *
     * The trailing ":" character is not part of the scheme and MUST NOT be
     * added.
     *
     * @see https://tools.ietf.org/html/rfc3986#section-3.1
     *
     * @return string the URI scheme
     */
    public function getScheme()
    {
        return $this->scheme;
    }

    /**
     * Retrieve the authority component of the URI.
     *
     * If no authority information is present, this method MUST return an empty
     * string.
     *
     * The authority syntax of the URI is:
     *
     * <pre>
     * [user-info@]host[:port]
     * </pre>
     *
     * If the port component is not set or is the standard port for the current
     * scheme, it SHOULD NOT be included.
     *
     * @see https://tools.ietf.org/html/rfc3986#section-3.2
     *
     * @return string the URI authority, in "[user-info@]host[:port]" format
     */
    public function getAuthority()
    {
        $authority = $this->getUserInfo();
        if (!empty($authority)) {
            $authority .= '@';
        }
        if (!empty($this->host)) {
            $authority .= $this->host;
        }
        if (!empty($this->port)) {
            if ($this->port != $this->getDefaultPort($this->scheme)) {
                $authority .= ':'.$this->port;
            }
        }

        return $authority;
    }

    /**
     * Retrieve the user information component of the URI.
     *
     * If no user information is present, this method MUST return an empty
     * string.
     *
     * If a user is present in the URI, this will return that value;
     * additionally, if the password is also present, it will be appended to the
     * user value, with a colon (":") separating the values.
     *
     * The trailing "@" character is not part of the user information and MUST
     * NOT be added.
     *
     * @return string the URI user information, in "username[:password]" format
     */
    public function getUserInfo()
    {
        $userInfo = '';
        if (!empty($this->user)) {
            $userInfo .= $this->user;

            if (!empty($this->pass)) {
                $userInfo .= ':'.$this->pass;
            }
        }

        return $userInfo;
    }

    /**
     * Retrieve the host component of the URI.
     *
     * If no host is present, this method MUST return an empty string.
     *
     * The value returned MUST be normalized to lowercase, per RFC 3986
     * Section 3.2.2.
     *
     * @see http://tools.ietf.org/html/rfc3986#section-3.2.2
     *
     * @return string the URI host
     */
    public function getHost()
    {
        return $this->host;
    }

    /**
     * Retrieve the port component of the URI.
     *
     * If a port is present, and it is non-standard for the current scheme,
     * this method MUST return it as an integer. If the port is the standard port
     * used with the current scheme, this method SHOULD return null.
     *
     * If no port is present, and no scheme is present, this method MUST return
     * a null value.
     *
     * If no port is present, but a scheme is present, this method MAY return
     * the standard port for that scheme, but SHOULD return null.
     *
     * @return int|null the URI port
     */
    public function getPort()
    {
        $scheme = $this->getScheme();
        if (empty($this->port) && empty($scheme)) {
            return null;
        }
        if (empty($this->port)) {
            return null;
        }

        return $this->port;
    }

    /**
     * Retrieve the path component of the URI.
     *
     * The path can either be empty or absolute (starting with a slash) or
     * rootless (not starting with a slash). Implementations MUST support all
     * three syntaxes.
     *
     * Normally, the empty path "" and absolute path "/" are considered equal as
     * defined in RFC 7230 Section 2.7.3. But this method MUST NOT automatically
     * do this normalization because in contexts with a trimmed base path, e.g.
     * the front controller, this difference becomes significant. It's the task
     * of the user to handle both "" and "/".
     *
     * The value returned MUST be percent-encoded, but MUST NOT double-encode
     * any characters. To determine what characters to encode, please refer to
     * RFC 3986, Sections 2 and 3.3.
     *
     * As an example, if the value should include a slash ("/") not intended as
     * delimiter between path segments, that value MUST be passed in encoded
     * form (e.g., "%2F") to the instance.
     *
     * @see https://tools.ietf.org/html/rfc3986#section-2
     * @see https://tools.ietf.org/html/rfc3986#section-3.3
     *
     * @return string the URI path
     */
    public function getPath()
    {
        return $this->path;
    }

    /**
     * Retrieve the query string of the URI.
     *
     * If no query string is present, this method MUST return an empty string.
     *
     * The leading "?" character is not part of the query and MUST NOT be
     * added.
     *
     * The value returned MUST be percent-encoded, but MUST NOT double-encode
     * any characters. To determine what characters to encode, please refer to
     * RFC 3986, Sections 2 and 3.4.
     *
     * As an example, if a value in a key/value pair of the query string should
     * include an ampersand ("&") not intended as a delimiter between values,
     * that value MUST be passed in encoded form (e.g., "%26") to the instance.
     *
     * @see https://tools.ietf.org/html/rfc3986#section-2
     * @see https://tools.ietf.org/html/rfc3986#section-3.4
     *
     * @return string the URI query string
     */
    public function getQuery()
    {
        return $this->query;
    }

    /**
     * Retrieve the fragment component of the URI.
     *
     * If no fragment is present, this method MUST return an empty string.
     *
     * The leading "#" character is not part of the fragment and MUST NOT be
     * added.
     *
     * The value returned MUST be percent-encoded, but MUST NOT double-encode
     * any characters. To determine what characters to encode, please refer to
     * RFC 3986, Sections 2 and 3.5.
     *
     * @see https://tools.ietf.org/html/rfc3986#section-2
     * @see https://tools.ietf.org/html/rfc3986#section-3.5
     *
     * @return string the URI fragment
     */
    public function getFragment()
    {
        return $this->fragment;
    }

    /**
     * Return an instance with the specified scheme.
     *
     * This method MUST retain the state of the current instance, and return
     * an instance that contains the specified scheme.
     *
     * Implementations MUST support the schemes "http" and "https" case
     * insensitively, and MAY accommodate other schemes if required.
     *
     * An empty scheme is equivalent to removing the scheme.
     *
     * @param string $scheme the scheme to use with the new instance
     *
     * @throws \InvalidArgumentException for invalid or unsupported schemes
     *
     * @return static a new instance with the specified scheme
     */
    public function withScheme($scheme)
    {
        if (!Scheme::isValidValue($scheme)) {
            throw new \InvalidArgumentException(sprintf('The scheme "%s" is not valid.', $scheme));
        }
        $clone = clone $this;
        $clone->scheme = $scheme;

        return $clone;
    }

    /**
     * Return an instance with the specified user information.
     *
     * This method MUST retain the state of the current instance, and return
     * an instance that contains the specified user information.
     *
     * Password is optional, but the user information MUST include the
     * user; an empty string for the user is equivalent to removing user
     * information.
     *
     * @param string      $user     the user name to use for authority
     * @param string|null $password the password associated with $user
     *
     * @return static a new instance with the specified user information
     */
    public function withUserInfo($user, $password = null)
    {
        $clone = clone $this;
        $clone->user = $user;
        $clone->pass = $password;

        return $clone;
    }

    /**
     * Return an instance with the specified host.
     *
     * This method MUST retain the state of the current instance, and return
     * an instance that contains the specified host.
     *
     * An empty host value is equivalent to removing the host.
     *
     * @param string $host the hostname to use with the new instance
     *
     * @throws \InvalidArgumentException for invalid hostnames
     *
     * @return static a new instance with the specified host
     */
    public function withHost($host)
    {
        if (null !== $host && !is_string($host)) {
            throw new \InvalidArgumentException(sprintf('The host "%s" is not valid.', $host));
        }
        $clone = clone $this;
        $clone->host = $host;

        return $clone;
    }

    /**
     * Return an instance with the specified port.
     *
     * This method MUST retain the state of the current instance, and return
     * an instance that contains the specified port.
     *
     * Implementations MUST raise an exception for ports outside the
     * established TCP and UDP port ranges.
     *
     * A null value provided for the port is equivalent to removing the port
     * information.
     *
     * @param int|null $port the port to use with the new instance; a null value
     *                       removes the port information
     *
     * @throws \InvalidArgumentException for invalid ports
     *
     * @return static a new instance with the specified port
     */
    public function withPort($port)
    {
        if (null != $port && !is_int($port)) {
            throw new \InvalidArgumentException(sprintf('The port "%s" is not valid.', $port));
        }
        $clone = clone $this;
        $clone->port = $port;

        return $clone;
    }

    /**
     * Return an instance with the specified path.
     *
     * This method MUST retain the state of the current instance, and return
     * an instance that contains the specified path.
     *
     * The path can either be empty or absolute (starting with a slash) or
     * rootless (not starting with a slash). Implementations MUST support all
     * three syntaxes.
     *
     * If the path is intended to be domain-relative rather than path relative then
     * it must begin with a slash ("/"). Paths not starting with a slash ("/")
     * are assumed to be relative to some base path known to the application or
     * consumer.
     *
     * Users can provide both encoded and decoded path characters.
     * Implementations ensure the correct encoding as outlined in getPath().
     *
     * @param string $path the path to use with the new instance
     *
     * @throws \InvalidArgumentException for invalid paths
     *
     * @return static a new instance with the specified path
     */
    public function withPath($path)
    {
        if (null !== $path && !is_string($path)) {
            throw new \InvalidArgumentException(sprintf('The path "%s" is not valid.', $path));
        }
        $clone = clone $this;
        $clone->path = $path;

        return $clone;
    }

    /**
     * Return an instance with the specified query string.
     *
     * This method MUST retain the state of the current instance, and return
     * an instance that contains the specified query string.
     *
     * Users can provide both encoded and decoded query characters.
     * Implementations ensure the correct encoding as outlined in getQuery().
     *
     * An empty query string value is equivalent to removing the query string.
     *
     * @param string $query the query string to use with the new instance
     *
     * @throws \InvalidArgumentException for invalid query strings
     *
     * @return static a new instance with the specified query string
     */
    public function withQuery($query)
    {
        if (null !== $query && !is_string($query)) {
            throw new \InvalidArgumentException(sprintf('The query "%s" is not valid.', $query));
        }
        $clone = clone $this;
        $clone->query = $query;

        return $clone;
    }

    /**
     * Return an instance with the specified URI fragment.
     *
     * This method MUST retain the state of the current instance, and return
     * an instance that contains the specified URI fragment.
     *
     * Users can provide both encoded and decoded fragment characters.
     * Implementations ensure the correct encoding as outlined in getFragment().
     *
     * An empty fragment value is equivalent to removing the fragment.
     *
     * @param string $fragment the fragment to use with the new instance
     *
     * @return static a new instance with the specified fragment
     */
    public function withFragment($fragment)
    {
        if (null !== $fragment && !is_string($fragment)) {
            throw new \InvalidArgumentException(sprintf('The fragment "%s" is not valid.', $fragment));
        }
        $clone = clone $this;
        $clone->fragment = $fragment;

        return $clone;
    }

    private function getDefaultPort($scheme)
    {
        return isset(Scheme::$defaultPort[$scheme]) ? Scheme::$defaultPort[$scheme] : null;
    }
}
