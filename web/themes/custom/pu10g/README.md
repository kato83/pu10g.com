# Drupal 9 用ブログテーマ

```
$ npm install
# 以下のいずれか
$ npm run webpack
$ npm run webpack:dev
```

## class.html について

cssを最適化するプラグインを導入しているため、jsで追加されるclassやタイプに対応していない。  
そのため、jsで追加されるようなclassやidをclass.htmlに記載することとする。