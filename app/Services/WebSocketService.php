<?php
/**
 * Created by TW Dev Team.
 * User: guoxiang
 * Date: 2018/6/6
 * Time: 14:57
 */

namespace App\Services;


use Hhxsv5\LaravelS\Swoole\WebSocketHandlerInterface;
use Swoole\Http\Request;
use Swoole\WebSocket\Frame;
use Swoole\WebSocket\Server;

/**
 * @see https://www.swoole.co.uk/docs/modules/swoole-websocket-server
 */
class WebSocketService implements WebSocketHandlerInterface
{
    // Declare constructor without parameters
    public function __construct()
    {
    }

    public function push($fd, array $data)
    {
        app('swoole')->push($fd, json_encode($data));
    }

    /**
     * Websocket连接成功回调方法
     * @param Server $server
     * @param Request $request
     */
    public function onOpen(Server $server, Request $request)
    {
        // 保存当前用户的长连接ID

        // 连接后应答推送
        $server->push($request->fd, json_encode([
            'data' => 'Welcome to LaravelS',
            'fd' => $request->fd,
            'uid' => 0,
            'messageType' => 0
        ]));

        $this->push($request->fd, ['test' => '123']);
        // throw new \Exception('an exception');// all exceptions will be ignored, then record them into Swoole log, you need to try/catch them
    }

    /**
     * 消息接收回调方法
     * @param Server $server
     * @param Frame $frame
     */
    public function onMessage(Server $server, Frame $frame)
    {
//        \Log::info('Received message', [$frame->fd, $frame->data, $frame->opcode, $frame->finish]);
//        $data = json_decode($frame->data, true);
        // 连接后应答推送
        $server->push($frame->fd, json_encode([
            'data' => 'Failed to link user',
            'fd' => $frame->fd,
            'messageType' => 0,
            'type' => 'test',
        ]));
        // throw new \Exception('an exception');// all exceptions will be ignored, then record them into Swoole log, you need to try/catch them
    }

    /**
     * Websocket关闭回调方法
     * @param Server $server
     * @param $fd
     * @param $reactorId
     */
    public function onClose(Server $server, $fd, $reactorId)
    {
        $server->push($fd, json_encode([
            'data' => 'Goodbye!',
            'fd' => $fd,
            'messageType' => 0
        ]));
//        \Log::info('websocket on close', ['fd' => $fd]);
//        WebsocketLog::where('fd', $fd)->delete(); // 解绑fd
        // throw new \Exception('an exception');// all exceptions will be ignored, then record them into Swoole log, you need to try/catch them
    }
}
