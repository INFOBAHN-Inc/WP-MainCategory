# WP Main Category

WP カスタムフィールドに任意のカテゴリを保存する

## USAGE

### HTML テンプレート用関数

#### *the_main_category()*
設定したメインカテゴリを出力する

```html
<span class="someclass"><?php the_main_category(); ?></span>
```

#### *the_main_category_slug()*

設定したメインカテゴリのスラッグを出力する

```html
<span class="<?php the_main_category_slug(); >">somecontents</span>
```

#### *have_main_category()*
メインカテゴリが設定されているか判定する

#### *get_main_category()*
メインカテゴリをテキストで返す
