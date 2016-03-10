<?php
/**
 * Created by Anton Korniychuk <ancor.dev@gmail.com>.
 */
namespace ancor\redis;

use Yii;
use yii\base\Component;


/**
 * Redis Database connection
 *
 * ```php
 * 'components' => [
 *     'redis' => \redis\redis\Redis::build([
 *         // 'host'    => '127.0.0.1',
 *         // 'port'    => 6379,
 *         // 'timeout' => 0,
 *
 *         // 'retryInterval' => null,
 *
 *         // 'password' => null,
 *         // 'database' => 0,
 *     ]),
 * ]
 * ```
 */
class Redis extends Component
{
    /**
     * @var string
     */
    public $host = '127.0.0.1';
    /**
     * @var integer
     */
    public $port = 6379;
    /**
     * @var float timeout in seconds
     */
    public $timeout = 0;
    /**
     * @var null should be null if $retry_interval is specified
     */
    public $reserved = null;
    /**
     * @var float reconnection timeout. Example: 100
     */
    public $retryInterval = null;
    /**
     * @var string
     */
    public $password = null;
    /**
     * @var integer database number
     */
    public $database = 0;

    /**
     * @var \Redis
     */
    public $conn;

    /**
     * @inheritdoc
     */
    public function init()
    {
        $this->conn = new \Redis();
        $successful = $this->conn->connect($this->host,
            $this->port,
            $this->timeout,
            $this->reserved,
            $this->retryInterval);

        if (!$successful) {
            throw new \RedisException('Can not connect to redis server');
        }
        if ($this->password) {
            $successful = $this->conn->auth($this->password);
            if (!$successful) {
                throw new \RedisException('Can not authorize');
            }
        }
        if ($this->database) {
            $successful = $this->conn->select($this->database);
            if (!$successful) {
                throw new \RedisException('Can not select database ('.$this->database.')');
            }
        }
    } // end init()

    /**
     * Configure redis connection.
     * build() method need to return Redis driver instance instead instance of this configuration class
     *
     * @param array $config
     * @return \Closure
     */
    public static function build(array $config = [])
    {
        /**
         * @return \Redis
         */
        return function() use ($config) {
            $redis = Yii::createObject(static::className(), $config);
            return $redis->conn;
        };
    } // end build()
}