<?php
namespace App\Channels;

class SmsMessage {

    protected $lines = [];
    protected $templateId;
    protected $to;
    protected $smsService;

    public function __construct($lines = [])
    {
        $this->lines = $lines;

        return $this;
    }

    public function templateId($templateId): self
    {
        $this->templateId = $templateId;

        return $this;
    }

    public function to($to): self
    {
      $this->to = $to;

         return $this;
    }

    public function line($line = ''): self
    {
        $this->lines[] = $line;

        return $this;
    }

    public function send($smsService) {


        if (!$this->templateId || !$this->to || !count($this->lines)) {
            throw new \Exception('SMS not correct.');
        }
        \Log::info("lines = ".print_r($this->lines,true));
        $text=collect($this->lines)->join("\n", "");
        $smsService->sendMsg($this->to, $text, $this->templateId);

        /*return Http::baseUrl($this->baseUrl)->withBasicAuth($this->user, $this->pass)
        ->asForm()
        ->post('sms', [
            'from' => $this->from,
            'to' => $this->to,
            'message' => $this->lines->join("\n", ""),
            'dryryn' => $this->dryrun
        ]);*/
    }

}
