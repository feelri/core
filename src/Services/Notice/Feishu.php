<?php

namespace Feelri\Core\Services\Notice;

use Feelri\Core\Exceptions\ErrorException;
use GuzzleHttp\Exception\GuzzleException;

/**
 * 飞书通知
 */
class Feishu extends \App\Services\Cloud\Bytedance\Feishu implements NoticeInterface
{
	/**
	 * 通知
	 *
	 * @param array $params
	 * @return array
	 * @throws ErrorException
	 * @throws GuzzleException
	 */
	public function notify(array $params): array
	{
		$url       = $this->config['webHookUrl'];
		$timestamp = time();
		$sign      = $this->signature($timestamp, $this->config['webHookSecret']);
		$response  = $this->client->post($url, [
			'json' => [
				'timestamp' => $timestamp,
				'sign'      => $sign,
				'msg_type'  => $params['type'] ?? 'text',
				'content'   => [
					'text' => $params['content']
				]
			]
		]);
		$data      = json_decode($response->getBody()->getContents(), true);
		if (!empty($data['code']) && (int)$data['code'] !== 0) {
			throw new ErrorException(empty($data['msg']) ? '飞书机器人消息通知失败' : $data['msg']);
		}

		return $data;
	}
}