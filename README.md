# ![delogo](https://deidee.com/logo.png?str=deLogo)

Ons bekende blokjeslogo kent verschillende implementaties in [_Python_](https://www.python.org/), [_Java_](https://www.java.com/) en [_PHP GD_](https://www.php.net/manual/en/book.image.php).

Dit is een poging de code bij elkaar te brengen, op te schonen en openbaar te maken. Qua techniek is voor [_PHP ImageMagick_](https://www.php.net/manual/en/book.imagick.php) gekozen.

## Gebruik

```php
$logo = new Delogo('tekst');
$logo->size = 24;
echo $logo;
```

## Implementatie

### Bitmapversie met witte achtergrond

```html
<img alt="jeIdee" src="https://deidee.com/logo.jpg?str=jeIdee">
```

### Semi-transparante bitmapversie

```html
<img alt="jeIdee" src="https://deidee.com/logo.png?str=jeIdee">
```

### Semi-transparante vectorversie

```html
<img alt="jeIdee" src="https://deidee.com/logo.svg?str=jeIdee">
```

Let op: De versies die via deze URL’s worden binnengehaald betreffen een oudere, maar meer uitgebreide versie van het beeldmerk. Het is de bedoeling dat ook deze vervangen worden door de versie uit deze repository, op het moment dat deze volwassen genoeg is.

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
- [ ] Achtergrondkleur in kunnen stellen.
- [ ] Hoogte en breedte kunnen forceren (voor extra witruimte of uitsnede).
- [ ] Pixels kunnen inverteren.
- [ ] CMYK-versie.
- [ ] GIF-versie.
- [ ] [_WebP_](https://developers.google.com/speed/webp)-versie.
- [ ] ASCII-versie.
- [ ] Thema’s terugbrengen (zie eerdere implementaties).
- [ ] Palet tijdsgeboden laten beïnvloeden (zie @deidee/dedate).
- [ ] Weg kunnen schrijven naar een map.
- [ ] Een plek geven op hetCDN.
- [ ] Karakterset uitbreiden.
- [ ] Een makkelijkere manier vinden om karakters te definiëren.
- [ ] Basisvorm kunnen definiëren (standaard vierkant).
