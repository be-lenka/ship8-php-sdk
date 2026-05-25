<?php
/**
 * Configuration
 * PHP version 7.4
 *
 * @category Class
 * @package  BeLenka\Ship8
 */

namespace BeLenka\Ship8;

/**
 * Configuration Class Doc Comment
 *
 * Holds connection-level configuration for the Ship8 API client: host URL,
 * credentials (Bearer / Basic), debug toggles and user-agent string.
 *
 * @category Class
 * @package  BeLenka\Ship8
 */
class Configuration
{
    public const VERSION = '0.2.0';

    public const BOOLEAN_FORMAT_INT = 'int';
    public const BOOLEAN_FORMAT_STRING = 'string';

    public const ENV_PRODUCTION = 'production';
    public const ENV_SANDBOX    = 'sandbox';

    /**
     * Canonical environment → host URL map. Single source of truth: every
     * environment-aware helper (setEnvironment, getEnvironment, getHostSettings)
     * derives from this map so prod/sandbox URLs are defined exactly once.
     */
    private const ENVIRONMENT_HOSTS = [
        self::ENV_PRODUCTION => 'https://portal.ship8.com',
        self::ENV_SANDBOX    => 'https://sandbox.ship8.com',
    ];

    /**
     * @var Configuration
     */
    private static $defaultConfiguration;

    /**
     * Associative array to store API key(s) (e.g. for header-based API key auth)
     *
     * @var string[]
     */
    protected $apiKeys = [];

    /**
     * Associative array to store API key prefixes (e.g. "Bearer")
     *
     * @var string[]
     */
    protected $apiKeyPrefixes = [];

    /**
     * Access token for OAuth2 / Bearer authentication
     *
     * @var string
     */
    protected $accessToken = '';

    /**
     * Boolean format for query string serialization
     *
     * @var string
     */
    protected $booleanFormatForQueryString = self::BOOLEAN_FORMAT_INT;

    /**
     * Username for HTTP basic authentication
     *
     * @var string
     */
    protected $username = '';

    /**
     * Password for HTTP basic authentication
     *
     * @var string
     */
    protected $password = '';

    /**
     * The API host. Ship8 paths begin with `/api/app/...` so the host has no
     * version-prefix segment of its own.
     *
     * @var string
     */
    protected $host = 'https://portal.ship8.com';

    /**
     * User agent of the HTTP request
     *
     * @var string
     */
    protected $userAgent = 'BeLenka-Ship8-PHP/0.2.0';

    /**
     * Debug switch (default false)
     *
     * @var bool
     */
    protected $debug = false;

    /**
     * Debug file location (log to STDOUT by default)
     *
     * @var string
     */
    protected $debugFile = 'php://output';

    /**
     * Temporary folder path
     *
     * @var string
     */
    protected $tempFolderPath;

    public function __construct()
    {
        $this->tempFolderPath = sys_get_temp_dir();
    }

    public function setApiKey(string $apiKeyIdentifier, string $key): self
    {
        $this->apiKeys[$apiKeyIdentifier] = $key;
        return $this;
    }

    public function getApiKey(string $apiKeyIdentifier): ?string
    {
        return $this->apiKeys[$apiKeyIdentifier] ?? null;
    }

    public function setApiKeyPrefix(string $apiKeyIdentifier, string $prefix): self
    {
        $this->apiKeyPrefixes[$apiKeyIdentifier] = $prefix;
        return $this;
    }

    public function getApiKeyPrefix(string $apiKeyIdentifier): ?string
    {
        return $this->apiKeyPrefixes[$apiKeyIdentifier] ?? null;
    }

    public function getApiKeyWithPrefix(string $apiKeyIdentifier): ?string
    {
        $prefix = $this->getApiKeyPrefix($apiKeyIdentifier);
        $apiKey = $this->getApiKey($apiKeyIdentifier);

        if ($apiKey === null) {
            return null;
        }

        return $prefix === null ? $apiKey : $prefix . ' ' . $apiKey;
    }

    public function setAccessToken(string $accessToken): self
    {
        $this->accessToken = $accessToken;
        return $this;
    }

    public function getAccessToken(): string
    {
        return $this->accessToken;
    }

    public function setBooleanFormatForQueryString(string $booleanFormat): self
    {
        $this->booleanFormatForQueryString = $booleanFormat;
        return $this;
    }

    public function getBooleanFormatForQueryString(): string
    {
        return $this->booleanFormatForQueryString;
    }

    public function setUsername(string $username): self
    {
        $this->username = $username;
        return $this;
    }

    public function getUsername(): string
    {
        return $this->username;
    }

    public function setPassword(string $password): self
    {
        $this->password = $password;
        return $this;
    }

    public function getPassword(): string
    {
        return $this->password;
    }

    public function setHost(string $host): self
    {
        $this->host = rtrim($host, '/');
        return $this;
    }

    public function getHost(): string
    {
        return $this->host;
    }

    /**
     * Point the client at a named environment (production / sandbox).
     * Sugar over setHost() — the canonical URLs live in ENVIRONMENT_HOSTS so
     * callers express intent ("I want sandbox") rather than data ("this URL").
     *
     * @throws \InvalidArgumentException for unknown environment names.
     */
    public function setEnvironment(string $environment): self
    {
        if (!isset(self::ENVIRONMENT_HOSTS[$environment])) {
            throw new \InvalidArgumentException(sprintf(
                'Unknown Ship8 environment "%s". Known environments: %s.',
                $environment,
                implode(', ', array_keys(self::ENVIRONMENT_HOSTS))
            ));
        }
        return $this->setHost(self::ENVIRONMENT_HOSTS[$environment]);
    }

    /**
     * Reverse-lookup the named environment for the current host. Returns null
     * when setHost() was used with a custom URL (proxy, mock, override).
     */
    public function getEnvironment(): ?string
    {
        $match = array_search($this->host, self::ENVIRONMENT_HOSTS, true);
        return $match === false ? null : $match;
    }

    public function setUserAgent(string $userAgent): self
    {
        if (!is_string($userAgent)) {
            throw new \InvalidArgumentException('User-agent must be a string.');
        }
        $this->userAgent = $userAgent;
        return $this;
    }

    public function getUserAgent(): string
    {
        return $this->userAgent;
    }

    public function setDebug(bool $debug): self
    {
        $this->debug = $debug;
        return $this;
    }

    public function getDebug(): bool
    {
        return $this->debug;
    }

    public function setDebugFile(string $debugFile): self
    {
        $this->debugFile = $debugFile;
        return $this;
    }

    public function getDebugFile(): string
    {
        return $this->debugFile;
    }

    public function setTempFolderPath(string $tempFolderPath): self
    {
        $this->tempFolderPath = $tempFolderPath;
        return $this;
    }

    public function getTempFolderPath(): string
    {
        return $this->tempFolderPath;
    }

    public static function getDefaultConfiguration(): Configuration
    {
        if (self::$defaultConfiguration === null) {
            self::$defaultConfiguration = new Configuration();
        }
        return self::$defaultConfiguration;
    }

    public static function setDefaultConfiguration(Configuration $config): void
    {
        self::$defaultConfiguration = $config;
    }

    public static function toDebugReport(): string
    {
        $report  = 'PHP SDK (BeLenka\\Ship8) Debug Report:' . PHP_EOL;
        $report .= '    OS: ' . php_uname() . PHP_EOL;
        $report .= '    PHP Version: ' . PHP_VERSION . PHP_EOL;
        $report .= '    SDK Version: ' . self::VERSION . PHP_EOL;
        $report .= '    Temp Folder Path: ' . self::getDefaultConfiguration()->getTempFolderPath() . PHP_EOL;
        return $report;
    }

    /**
     * Available host environments. The first entry is the default.
     * Derived from ENVIRONMENT_HOSTS so URLs are defined in one place; the
     * return shape (numerically-indexed list of url+description pairs) is
     * preserved for backward compatibility.
     *
     * @return array<int, array{url: string, description: string}>
     */
    public function getHostSettings(): array
    {
        $descriptions = [
            self::ENV_PRODUCTION => 'Production API',
            self::ENV_SANDBOX    => 'Sandbox API',
        ];
        $out = [];
        foreach (self::ENVIRONMENT_HOSTS as $env => $url) {
            $out[] = [
                'url' => $url,
                'description' => $descriptions[$env] ?? ucfirst($env) . ' API',
            ];
        }
        return $out;
    }
}
