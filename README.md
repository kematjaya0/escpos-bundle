# escpos-bundle
escpos bundle for symfony (branch `6.4`: Symfony 6.4, PHP >= 8.1, mike42/escpos-php 3.x / 4.x)

1. installation
```
composer require kematjaya/escpos-bundle
```
2. add to config/bundles.php
```
Kematjaya\EscposBundle\EscposBundle::class => ['all' => true]
```
3. print
```php
use Kematjaya\EscposBundle\Client\DefaultClient;
use Kematjaya\EscposBundle\Formatter\TextFormatter;
use Kematjaya\EscposBundle\Helper\PrinterHelperInterface;

public function print(PrinterHelperInterface $printerHelper)
{
    $formatter = (new TextFormatter())
        ->setHeader('TOKO ABC')
        ->addText('Total: 10.000')->addEnter();

    // printer share windows: smb://guest@KASIR-01/POS-58
    $client = (new DefaultClient())->setComputerName('KASIR-01')->setPrinterName('POS-58');

    // atau koneksi lain:
    // ->setConnectionName('tcp://192.168.1.10:9100')  printer jaringan (port default 9100)
    // ->setConnectionName('cups://POS-58')            printer CUPS
    // ->setConnectionName('file:///dev/usb/lp0')      device / file
    // ->setPrinterProfileName('TM-T88V')              capability profile (default POS-5890)

    $printerHelper->print($formatter, $client);
}
```

## Test
```
sh docker/test.sh all
```
