# Contao Blog Bundle

Really nice blog extension!

## Installation - Contao Managed Edition:

add to your composer.json:

```json
...
    "require": {
      "xuad/contao-blog-bundle": "^4.5"
    },
    "repositories": [
      {
        "type": "vcs",
        "url": "rumpel@git.xuad.de:xuad/contao-blog-bundle.git"
      },
    ]
...
```

## Customizing
Add custom configuration at app/config.yml

```yaml
xuad_blog:
  enabled: true
  news_archive_category_parameter_name: 'category'
```