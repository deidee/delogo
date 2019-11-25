# ![delogo](https://deidee.com/logo.png?str=deLogo)

Ons bekende blokjelogo kent verschillende implementaties in _python_, _Java_ en [_PHP GD_](https://www.php.net/manual/en/book.image.php).

Dit is een poging de code bij elkaar te brengen, op te schonen en openbaar te maken. Qua techniek is voor [_PHP ImageMagick_](https://www.php.net/manual/en/book.imagick.php) gevallen.

## Gebruik

```php
$logo = new Delogo('tekst');
$logo->size = 24;
echo $logo;
```

## Te doen

- [ ] Elke kolom afzonderlijk kunnen beïnvloeden.
- [ ] Elke rij afzonderlijk kunnen beïnvloeden.
- [ ] Elke cel afzonderlijk kunnen beïnvloeden.
- [ ] Elk karakter afzonderlijk kunnen beïnvloeden.
- [ ] Elke regel afzonderlijk kunnen beïnvloeden.
- [ ] Kleurenpalet vullen.
- [ ] Kleurenpalet kunnen beïnvloeden.
- [ ] SVG-versie.
- [ ] Geanimeerde SVG-versie.
- [ ] Transparante achtergrond voor PNG-versie.
