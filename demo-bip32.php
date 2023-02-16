<?php

require __DIR__.'/vendor/autoload.php';

$mnemonic = 'ceiling mixed inmate donate arctic scene pave address kangaroo ill crush neck';

$wallet1 = '0x3a1108329e10323449d61fb60fcc531705D24125';
$private1 = 'f429ddc1d39eac60594e0366c7d7763afa78f342196fa4bb48fe9fa134fa5378';

$wallet2 = '0xDfF2A3e87f98304321CA3e4cE7E16dBa2051fbd8';
$private2 = '379169e17fb1b40e188df9489e1c044ee338ed2070ebae83d3d816466128ccff';


$mnemonicObj = \FurqanSiddiqui\BIP39\BIP39::Words($mnemonic);

$bip32 = new \FurqanSiddiqui\BIP32\BIP32(
    new \FurqanSiddiqui\ECDSA\Curves\Secp256k1(),
    \FurqanSiddiqui\Ethereum\Networks\Ethereum::Mainnet()
);

$wrongHdKeyPear = $bip32->masterKeyFromSeed(new \FurqanSiddiqui\BIP32\Buffers\Bits512($mnemonicObj->generateSeed()));

echo 'WRONG:'.PHP_EOL.PHP_EOL;
$wrongPrivate1 = $wrongHdKeyPear->derivePath("m/44'/60'/0'/0/0")->privateKey()->eccPrivateKey->private->toBase16();
echo sprintf('%s != %s', $private1, $wrongPrivate1).PHP_EOL;
$wrongPrivate2 = $wrongHdKeyPear->derivePath("m/44'/60'/0'/0/1")->privateKey()->eccPrivateKey->private->toBase16();
echo sprintf('%s != %s', $private2, $wrongPrivate2).PHP_EOL;


// Whats correct
$rightHdKeyPear = $bip32->masterKeyFromEntropy(new \FurqanSiddiqui\BIP32\Buffers\Bits512($mnemonicObj->generateSeed()));

echo PHP_EOL.PHP_EOL.'CORRECT:'.PHP_EOL.PHP_EOL;
$rightPrivate1 = $rightHdKeyPear->derivePath("m/44'/60'/0'/0/0")->privateKey()->eccPrivateKey->private->toBase16();
echo sprintf('%s == %s', $private1, $rightPrivate1).PHP_EOL;
$rightPrivate2 = $rightHdKeyPear->derivePath("m/44'/60'/0'/0/1")->privateKey()->eccPrivateKey->private->toBase16();
echo sprintf('%s == %s', $private2, $rightPrivate2).PHP_EOL;