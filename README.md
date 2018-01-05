# Visitors

PMMPプラグインです(Written in PHP)

## Description

これまでに訪れたプレイヤーの実人数と延べ人数を記録します

## Download

### [![MCBE_Forum](https://forum.mcbe.jp/styles/uix_dark/images/logo.png)]()

## Demo

## For Developer

<details><summary>For Developer</summary>
###注意 `plugin.ymlに「depend: Visitors」を追加してください。`

`xanadu2875\Visitors\Viitros::getInstance()` でPreTeleporterの関数にアクセスできます。

| Functions | Param | Description |
| :-------: | :---: | :---------: |
| Visitors#getNumber(void) | | 実人数を返します |
| Visitors#getTotal(void) | | 延べ人数を返します |

例:
```PHP
use xanadu2875\preteleporter\PreTeleporter;
Server::getInstance()->getLogger()->notice("実人数: {Visitors::getInstance()->getNumber()} 延べ人数: {Visitors::getInstance()->getTotal()}");
```

</details>

## Usage

実人数をリセットしたいときはTotal.dbを、延べ人数を記録したいときはNumber.jsonをそれぞれ消去してください

## Author

<details><summary>Xanadu2875</summary>

Twitter
[@xanadu2875](https://twitter.com/xanadu2875)

Lobi
[1a8ca](https://web.lobi.co/user/1a8ca6d4fdd1d87e0f26c68e18f08de6413f7d36)
</details>

## License

GPLLv3

## TODO

- 一日の実人数と延べ人数を記録できるようにする

## Anything Else

- コミットくだしあ
- ポプテピピック放送おめ！
