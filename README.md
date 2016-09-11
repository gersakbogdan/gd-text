gd-text
=======
###Image & Font basic usage example
```php
<?php
require __DIR__.'/../vendor/autoload.php';

use GDText\ImageCreator as Image;
use GDText\Box;
use GDText\Font;
use GDText\Color;


// Franchise
$font = new Font(__DIR__.'/fonts/Fabian.ttf');
$font->setSize(50)
     ->setColor(new Color(255, 75, 140))
     ->setAngle(-10);

$image = Image::canvas(500, 500, new Color(0, 18, 64));
$image->text('Franchise', 20, 60, $font);


// Pacifico
$font = new Font(__DIR__.'/fonts/Pacifico.ttf');
$font->setSize(80)
     ->setColor(new Color(255, 255, 255))
     ->setAngle(10);

$image->text('Pacifico', 130, 280, $font);


// Prisma
$font = new Font(__DIR__.'/fonts/Prisma.ttf');
$font->setSize(70)->setColor(new Color(148, 212, 1));

$image->text('Prisma', 220, 460, $font);


header("Content-type: image/png;");
imagepng($image->getResource(), null, 9, PNG_ALL_FILTERS);
```

###Basic usage example (with rotation)
```php
<?php
require __DIR__.'/../vendor/autoload.php';

use GDText\ImageCreator as Image;
use GDText\Box;
use GDText\Font;
use GDText\Color;

$image = Image::canvas(500, 500, new Color(0, 18, 64));
$im = $image->getResource();

$font = new Font(__DIR__.'/Franchise-Bold-hinted.ttf'); // http://www.dafont.com/franchise.font
$font->setColor(new Color(255, 75, 140))
     ->setShadow(new Color(0, 0, 0, 50), 2, 2)
     ->setSize(40)
     ->setAngle(-10);

$box = new Box($im, $font);
$box->setBox(20, 20, 460, 460);
$box->setTextAlign('left', 'top');
$box->draw("Franchise\nBold");


$font->setFile(__DIR__.'/Pacifico.ttf') // http://www.dafont.com/pacifico.font
     ->setColor(new Color(255, 255, 255))
     ->setShadow(new Color(0, 0, 0, 50), 0, -2)
     ->setSize(80)
     ->setAngle(10);

$box = new Box($im, $font);
$box->setBox(20, 20, 460, 460);
$box->setTextAlign('center', 'center');
$box->draw("Pacifico");


$font->setFile(__DIR__.'/Prisma.otf') // http://www.dafont.com/prisma.font
     ->setColor(new Color(148, 212, 1))
     ->setShadow(new Color(0, 0, 0, 50), 0, -2)
     ->setSize(70)
     ->setAngle(0);

$box = new Box($im, $font);
$box->setBox(20, 20, 460, 460);
$box->setTextAlign('right', 'bottom');
$box->draw("Prisma");

header("Content-type: image/png");
imagepng($im);
```

Example output:

![fonts example](examples/angle.png)

Multilined text
---------------

```php
<?php
require __DIR__.'/../vendor/autoload.php';

use GDText\ImageCreator as Image;
use GDText\Box;
use GDText\Font;
use GDText\Color;

$image = Image::canvas(500, 500, new Color(0, 18, 64));
$im = $image->getResource();

$font = new Font(__DIR__.'/Minecraftia.ttf'); // http://www.dafont.com/minecraftia.font
$font->setColor(new Color(255, 75, 140))
     ->setShadow(new Color(0, 0, 0, 50), 2, 2)
     ->setLineHeight(2)
     ->setSize(10);

$box = new Box($im, $font);
//$box->enableDebug();
$box->setBox(20, 20, 460, 460);
$box->setTextAlign('left', 'top');
$box->draw(
    "    Lorem ipsum dolor sit amet, consectetur adipiscing elit. Nulla eleifend congue auctor. Nullam eget blandit magna. Fusce posuere lacus at orci blandit auctor. Aliquam erat volutpat. Cras pharetra aliquet leo. Cras tristique tellus sit amet vestibulum ullamcorper. Aenean quam erat, ullamcorper quis blandit id, sollicitudin lobortis orci. In non varius metus. Aenean varius porttitor augue, sit amet suscipit est posuere a. In mi leo, fermentum nec diam ut, lacinia laoreet enim. Fusce augue justo, tristique at elit ultricies, tincidunt bibendum erat.\n\n    Aenean feugiat dignissim dui non scelerisque. Cras vitae rhoncus sapien. Suspendisse sed ante elit. Duis id dolor metus. Vivamus congue metus nunc, ut consequat arcu dapibus vel. Ut sed ipsum sollicitudin, rutrum quam ac, fringilla risus. Phasellus non tincidunt leo, sodales venenatis nisl. Duis lorem odio, porta quis laoreet ut, tristique a justo. Morbi dictum dictum est ut facilisis. Duis suscipit sem ligula, at commodo risus pulvinar vehicula. Sed quis quam ac quam scelerisque dapibus id non justo. Sed mollis enim id neque tempus, a congue nulla blandit. Aliquam congue convallis lacinia. Aliquam commodo eleifend nisl a consectetur.\n\n    Maecenas sem nisl, adipiscing nec ante sed, sodales facilisis lectus. Pellentesque habitant morbi tristique senectus et netus et malesuada fames ac turpis egestas. Ut bibendum malesuada ipsum eget vestibulum. Pellentesque interdum tempor libero eu sagittis. Suspendisse luctus nisi ante, eget tempus erat tristique sed. Duis nec pretium velit. Praesent ornare, tortor non sagittis sollicitudin, dolor quam scelerisque risus, eu consequat magna tellus id diam. Fusce auctor ultricies arcu, vel ullamcorper dui condimentum nec. Maecenas tempus, odio non ullamcorper dignissim, tellus eros elementum turpis, quis luctus ante libero et nisi.\n\n    Phasellus sed mauris vel lorem tristique tempor. Pellentesque ornare purus quis ullamcorper fermentum. Curabitur tortor mauris, semper ut erat vitae, venenatis congue eros. Ut imperdiet arcu risus, id dapibus lacus bibendum posuere. Etiam ac volutpat lectus. Vivamus in magna accumsan, dictum erat in, vehicula sem. Donec elementum lacinia fringilla. Vivamus luctus felis quis sollicitudin eleifend. Sed elementum, mi et interdum facilisis, nunc eros suscipit leo, eget convallis arcu nunc eget lectus. Quisque bibendum urna sit amet varius aliquam. In mollis ante sit amet luctus tincidunt."
);

header("Content-type: image/png;");
imagepng($im, null, 9, PNG_ALL_FILTERS);
```

Text stroke
-----------

```php
<?php
require __DIR__.'/../vendor/autoload.php';

use GDText\ImageCreator as Image;
use GDText\Box;
use GDText\Font;
use GDText\Color;

$image = Image::canvas(500, 500, new Color(0, 18, 64));
$im = $image->getResource();

$font = new Font(__DIR__.'/Elevant bold.ttf'); // http://www.dafont.com/elevant-by-pelash.font
$font->setColor(new Color(255, 255, 255))
     ->setSize(50)
     ->setStrokeColor(new Color(255, 75, 140)) // Set stroke color
     ->setStrokeSize(3); // Stroke size in pixels

$box = new Box($im, $font);
$box->setBox(15, 20, 460, 460);
$box->setTextAlign('center', 'center');

$box->draw("Elevant");

header("Content-type: image/png;");
imagepng($im, null, 9, PNG_ALL_FILTERS);
```

Text background
-----------

```php
<?php
require __DIR__.'/../vendor/autoload.php';

use GDText\ImageCreator as Image;
use GDText\Box;
use GDText\Font;
use GDText\Color;

$image = Image::canvas(500, 500, new Color(0, 18, 64));
$im = $image->getResource();

$font = new Font(__DIR__.'/BebasNeue.otf'); // http://www.dafont.com/elevant-by-pelash.font
$font->setColor(new Color(255, 255, 255))
     ->setSize(100);

$box = new Box($im, $font);
$box->setBox(15, 20, 460, 460);
$box->setTextAlign('center', 'center');

$box->setBackgroundColor(new Color(255, 86, 77));

$box->draw("Bebas Neue");

header("Content-type: image/png;");
imagepng($im, null, 9, PNG_ALL_FILTERS);
```

Demos
------
Line height demo:

![line height example](examples/lineheight.gif)

Text alignment demo:

![align example](examples/alignment.gif)

Text stroke demo:

![stroke example](examples/stroke.gif)

Text background demo:

![stroke example](examples/background.gif)

Debug mode enabled demo:

![debug example](examples/debug.png)
