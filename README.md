# Template Helper

Loads and displays or processes a template file

## Very simple usage

```
use losthost\templateHelper\Template;

$template = new Template('template-file.tpl');
$template->display(); 
```

This will display the content of file `templates/default/template-file.tpl`.
It seems not very usefull, so you can create more complex templates as in next example.

## More complex usage

Create a template file ex. `templatex/default/simple-template.tpl` with code:
```
Hello <?=$this->name; ?>!
```

Now to display "Hello John!" do the following:
```
use losthost\templateHelper\Template;

$template = new Template('simple-template.tpl');
$template->assing('name', 'John');
$template->display();
```

## Multilang usage

Use `$template = new Template('template.tpl', 'de');` to use templates in `templates/de/` instead of `templates/default/`.

You can change default templates dir from `templates/` to `anydir/` you want by using `$template->setTemplateDir('anydir')`.