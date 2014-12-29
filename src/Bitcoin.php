<?php

namespace Cryptocurrency;

use \Monolog\Logger;

/**
 * Represents the Bitcoin cryptocurrency.
 */
class Bitcoin extends \Openclerk\Currencies\Cryptocurrency
  implements \Openclerk\Currencies\BlockCurrency, \Openclerk\Currencies\DifficultyCurrency {

  function getCode() {
    return "btc";
  }

  function getName() {
    return "Bitcoin";
  }

  function getURL() {
    return "http://bitcoin.org/";
  }

  function getCommunityLinks() {
    return array(
      "https://www.weusecoins.com/en/" => "What is Bitcoin?",
    );
  }

  function isValid($address) {
    // very simple check according to https://bitcoin.it/wiki/Address
    if (strlen($address) >= 27 && strlen($address) <= 34 && ((substr($address, 0, 1) == "1" || substr($address, 0, 1) == "3"))
        && preg_match("#^[A-Za-z0-9]+$#", $address)) {
      return true;
    }
    return false;
  }

  function hasExplorer() {
    return true;
  }

  function getExplorerName() {
    return "Blockchain.info";
  }

  function getExplorerURL() {
    return "https://blockchain.info/";
  }

  function getBalanceURL($address) {
    return sprintf("https://blockchain.info/address/%s", urlencode($address));
  }

  /**
   * @throws {@link BalanceException} if something happened and the balance could not be obtained.
   */
  function getBalance($address, Logger $logger) {
    $fetcher = new Services\BlockchainInfo();
    return $fetcher->getBalance($address, $logger);
  }

  function getBlockCount(Logger $logger) {
    $fetcher = new Services\BlockchainInfo();
    return $fetcher->getBlockCount($logger);
  }

  function getDifficulty(Logger $logger) {
    $fetcher = new Services\BlockchainInfo();
    return $fetcher->getDifficulty($logger);
  }

}
