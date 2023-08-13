<?php

namespace AdventureTime\Services;

class JWT
{
    /**
     * @var array|string[] $header
     */
    private static array $header = [
        'alg' => 'SHA256',
        'type' => 'JWT'
    ];

    /**
     * @var string $app_key
     */
    protected static string $app_key;

    /**
     * JWT constructor.
     * @param string $app_key
     */
    public function __construct(string $app_key) {
        self::$app_key = $app_key;
    }

    /**
     * @param string $token
     * @return bool
     */
    public static function verify(string $token): bool
    {
        $tokens = explode('.', $token);

        if (count($tokens) !== 3) {
            // throw new \Exception('Невалидный токен.');
            return false;
        }

        [$header, $payload, $sign] = $tokens;

        $decodeHeader = json_decode(self::base64decode($header), true);

        if (empty($decodeHeader['alg'] || $decodeHeader['type'] !== 'JWT')) {
            // throw new \Exception('Невалидный токен. Alg or type');
            return false;
        }

        if (self::signature(join('.', [$header, $payload]), self::$app_key) !== $sign) {
            // throw new \Exception('Невалидная подпись.');
            return false;
        }

        $payload = json_decode(self::base64decode($payload), true);

        if (! isset($payload['time']) || $payload['time'] < time()) {
            return false;
        }

        return true;
    }

    /**
     * @param $data
     * @return string
     */
    public static function base64encode($data): string
    {
        return rtrim(strtr(base64_encode($data), '+/', '-_'), '=');
    }

    /**
     * @param $data
     * @return false|string
     */
    public static function base64decode($data)
    {
        return base64_decode(str_pad(strtr($data, '-_', '+/'), strlen($data) % 4, '='));
    }

    /**
     * @param array $payload
     * @return string
     */
    public static function generateToken(array $payload): string
    {
        $header = self::base64encode(json_encode(self::$header,JSON_UNESCAPED_UNICODE));
        $payload = self::base64encode(json_encode($payload,JSON_UNESCAPED_UNICODE));
        $sign = self::signature(join('.', [$header, $payload]), self::$app_key);

        return join('.', [$header, $payload, $sign]);
    }

    /**
     * @param string $string
     * @param string $key
     * @return string
     */
    private static function signature(string $string, string $key): string
    {
        return self::base64encode(hash_hmac('SHA256', $string, $key, true));
    }
}