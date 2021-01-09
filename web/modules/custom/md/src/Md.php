<?php

namespace Drupal\md;

class Md extends \cebe\markdown\GithubMarkdown
{
  protected function renderHeadline($block)
  {
    $tag = 'h' . $block['level'];
    return "<$tag class=\"uk-heading-divider\" id=\"" . $this->renderAbsy($block['content']) . "\"><a class=\"uk-link-text\" href=\"#" . $this->renderAbsy($block['content']) . "\">" . $this->renderAbsy($block['content']) . "</a></$tag>\n";
  }

  protected function renderLink($block)
  {
    if (isset($block['refkey'])) {
      if (($ref = $this->lookupReference($block['refkey'])) !== false) {
        $block = array_merge($block, $ref);
      } else {
        if (strncmp($block['orig'], '[', 1) === 0) {
          return '[' . $this->renderAbsy($this->parseInline(substr($block['orig'], 1)));
        }
        return $block['orig'];
      }
    }

    $url = htmlspecialchars($block['url'], ENT_COMPAT | ENT_HTML401, 'UTF-8');

    $request = \Drupal::request();
    $myHostName = $request->getHost();
    $linkHostName = parse_url(htmlspecialchars($block['url'], ENT_COMPAT | ENT_HTML401, 'UTF-8'))['host'] ?? null;
    $isBlankFlg = !empty($linkHostName) && $myHostName !== $linkHostName;

    return '<a href="' . $url . '"'
      . (empty($block['title']) ? '' : ' title="' . htmlspecialchars($block['title'], ENT_COMPAT | ENT_HTML401 | ENT_SUBSTITUTE, 'UTF-8') . '"')
      . ($isBlankFlg ? ' target="_blank" rel="nofollow noopener noreferrer"' : '')
      . '>' . $this->renderAbsy($block['text']) . ($isBlankFlg ? '<span class="blank-icon" uk-icon="icon: move; ratio: 0.7"></span>' : '') . '</a>';
  }

  protected function composeTable($head, $body)
  {
    return "<div class=\"uk-overflow-auto\"><table class=\"uk-table uk-table-divider\">\n<thead>\n$head</thead>\n<tbody>\n$body</tbody>\n</table></div>\n";
  }
}
