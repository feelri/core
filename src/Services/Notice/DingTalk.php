<?php

namespace Feelri\Core\Services\Notice;

use Feelri\Core\Exceptions\ErrorException;
use GuzzleHttp\Exception\GuzzleException;

/**
 * 钉钉通知
 */
class DingTalk extends \App\Services\Cloud\Alibaba\DingTalk implements NoticeInterface
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
		$timestamp = (int)(microtime(true) * 1000);
		$sign      = $this->signature($timestamp, $this->config['webHookSecret']);
		$response  = $this->client->post("{$url}&timestamp={$timestamp}&sign={$sign}", [
			'json' => [
				'msgtype' => $params['type'] ?? 'text',
				'text'    => [
					'content' => $params['content']
				]
			]
		]);
		$data      = json_decode($response->getBody()->getContents(), true);
		if (!empty($data['errcode']) && (int) $data['errcode'] == 0) {
			throw new ErrorException(empty($data['errmsg']) ? '钉钉机器人消息通知失败' : $data['errmsg']);
		}

		return $data;
	}
}
