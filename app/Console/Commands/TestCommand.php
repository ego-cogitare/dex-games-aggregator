<?php

namespace App\Console\Commands;


use FastSimpleHTMLDom\Document;

/**
 * Class TestCommand
 * @package App\Console\Commands
 */
class TestCommand extends AbstractCommand
{
    /**
     * The name and signature of the console command.
     * @var string
     */
    protected $signature = 'test:command';

    /**
     * Execute the console command.
     * @return mixed
     * @throws \Exception
     */
    public function handle()
    {
        /** Get all exchanges */
        $html = file_get_contents('https://api.coingecko.com/api/v3/exchanges/list');
        $exchanges = json_decode($html);

        echo 'Total:', count($exchanges), PHP_EOL;

        $info = [];

        foreach ($exchanges as $i => $exchange) {
            $url = 'https://www.coingecko.com/en/exchanges/' . $exchange->id;
            echo $i , $url, PHP_EOL;

            // Create DOM from URL
            $html = Document::file_get_html($url);

            $counts = $html->find('.coingecko .tab-content .gecko-table-container.mt-4 .d-flex.justify-content-between .section-header.mt-0.mb-0 span');

            try {
                $v1 = $html->find('.trade-info.text-right.col-12.col-lg-4.row .text-right .text-right .pb-2')->getArrayCopy()[0]->getAttribute('data-price-btc') * 9050;
            } catch (\Exception $e) {
                $v1 = 0;
            }

            try {
                $v2 = $html->find('.trade-info.text-right.col-12.col-lg-4.row .top-content .trade-vol-amount')->getArrayCopy()[0]->getAttribute('data-price-btc') * 9050;
            } catch (\Exception $e) {
                $v2 = 0;
            }

            /** @var int $trustScore */
            $trustScore = (int)$html->find('.card.col-10.offset-1.shadow-sm.border-top-0 div div div + div')->plaintext;

            $info[$exchange->id] = [
                'name' => $exchange->name,
                'geckoUrl' => $url,
                'marketUrl' => $html->find('.exchange-details-header-content .exchange-links a')->getArrayCopy()[0]->getAttribute('href'),
                'reportedPrice' => $v1,
                'normalizedPrice' => $v2,
                'coins' => (int)$counts->getArrayCopy()[1]->plaintext,
                'tradingPairs' => (int)$counts->getArrayCopy()[0]->plaintext,
                'trustScore' => $trustScore,
                'flags' => [],
            ];

            // Find all post blocks
            /** @var \FastSimpleHTMLDom\Element $el */
            foreach ($html->find('.d-flex.justify-content-between.mt-3 + div table tr + tr') as $el) {
                /** @var \FastSimpleHTMLDom\NodeList $tds */
                $tds = $el->find('td');

                /** @var \FastSimpleHTMLDom\Element $td */
                foreach ($tds->getIterator() as $i => $td) {
                    $count = $td->find('i.fa-check')->count();
                    $info[$exchange->id]['flags'][$i + 1] = $count > 0;
                }
            }

            usleep(200000);
        }

        dd(json_encode($info));
    }
}
