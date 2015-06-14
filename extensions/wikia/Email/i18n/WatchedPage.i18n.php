<?php
$messages = array();

$messages['en'] = array(
	'emailext-watchedpage-article-edited-subject' => '$1 on {{SITENAME}} has been edited by $2',
	'emailext-watchedpage-article-edited-subject-anonymous' => '$1 on {{SITENAME}} has been edited',
	'emailext-watchedpage-article-protected-subject' => '$1 on {{SITENAME}} has been protected by $2',
	'emailext-watchedpage-article-unprotected-subject' => '$1 on {{SITENAME}} has been unprotected by $2',
	'emailext-watchedpage-article-renamed-subject' => '$1 on {{SITENAME}} has been renamed by $2',
	'emailext-watchedpage-article-deleted-subject' => '$1 on {{SITENAME}} has been deleted by $2',
	'emailext-watchedpage-article-edited' => "'''[$1 $2] on [{{SERVER}} {{SITENAME}}] has been edited. Check it out!'''",
	'emailext-watchedpage-article-protected' => "'''[$1 $2] on [{{SERVER}} {{SITENAME}}] has been protected. Check it out!'''",
	'emailext-watchedpage-article-unprotected' => "'''[$1 $2] on [{{SERVER}} {{SITENAME}}] has been unprotected. Check it out!'''",
	'emailext-watchedpage-article-renamed' => "'''[$1 $2] on [{{SERVER}} {{SITENAME}}] has been renamed. Check it out!'''",
	'emailext-watchedpage-article-deleted' => "'''[$1 $2] on [{{SERVER}} {{SITENAME}}] has been deleted.'''",
	'emailext-watchedpage-no-summary' => 'No edit summary was given',
	'emailext-watchedpage-diff-button-text' => 'Compare changes',
	'emailext-watchedpage-deleted-button-text' => 'See article history',
	'emailext-watchedpage-article-link-text' => "[$1 Head over to '''$2''' to see what's new]",
	'emailext-watchedpage-view-all-changes' => "[$1 View all changes to '''$2''']",
);

$messages['qqq'] = array(
	'emailext-watchedpage-article-edited-subject' => 'Subject line for watched article email when article was edited. $1 -> article name, $2 -> username of user who edited the article',
	'emailext-watchedpage-article-edited-subject-anonymous' => 'Subject line for watched article email edited by an anonymous user. $1 -> article name',
	'emailext-watchedpage-article-unprotected-subject' => 'Subject line for watched article email when article was unprotected. $1 -> article name, $2 -> username of user who edited the article',
	'emailext-watchedpage-article-renamed-subject' => 'Subject line for watched article email when article was renamed. $1 -> article name, $2 -> username of user who edited the article',
	'emailext-watchedpage-article-deleted-subject' => 'Subject line for watched article email when article was deleted. $1 -> article name, $2 -> username of user who edited the article',
	'emailext-watchedpage-article-edited' => 'Message to the user that an article they are following has been edited. $1 -> article url, $2 -> article title',
	'emailext-watchedpage-article-protected' => 'Message to the user that an article they are following has been protected. $1 -> article url, $2 -> article title',
	'emailext-watchedpage-article-unprotected' => 'Message to the user that an article they are following has been unprotected. $1 -> article url, $2 -> article title',
	'emailext-watchedpage-article-renamed' => 'Message to the user that an article they are following has been renamed. $1 -> article url, $2 -> article title',
	'emailext-watchedpage-article-deleted' => 'Message to the user that an article they are following has been deleted. $1 -> article url, $2 -> article title',
	'emailext-watchedpage-no-summary' => 'Message shown when the editor did not leave an edit summary',
	'emailext-watchedpage-diff-button-text' => 'Text for button that, when clicked, navigates to the diff page referencing this change.',
	'emailext-watchedpage-deleted-button-text' => 'Text for button that, when clicked, navigates to the deleted page.',
	'emailext-watchedpage-article-link-text' => 'Call to action to visit the article page. $1 -> article url, $2 -> article title.',
	'emailext-watchedpage-view-all-changes' => 'Call to action to visit history of the article page. $1 -> article history url, $2 -> article title',
);

$messages['de'] = array(
	'emailext-watchedpage-article-edited-subject' => '{{SITENAME}}: Der Artikel „$1“ wurde von $2 bearbeitet',
	'emailext-watchedpage-article-edited' => "'''[$1 $2] auf [{{SERVER}} {{SITENAME}}] wurde bearbeitet. Sieh es dir an!'''",
	'emailext-watchedpage-diff-button-text' => 'Änderungen vergleichen',
	'emailext-watchedpage-article-link-text' => "[$1 Unter '''$2''' siehst du, was es Neues gibt]",
	'emailext-watchedpage-view-all-changes' => "[$1 Alle Änderungen an '''$2''' ansehen]",
	'emailext-watchedpage-no-summary' => 'Es wurde keine Zusammenfassung der Bearbeitung angegeben.',
	'emailext-watchedpage-subject-anonymous' => '$1 wurde auf {{SITENAME}} bearbeitet',
	'emailext-watchedpage-article-protected-subject' => '{{SITENAME}}: Der Artikel „$1“ wurde von $2 geschützt',
	'emailext-watchedpage-article-unprotected-subject' => '{{SITENAME}}: $2 hat den Schutz vom Artikel „$1“ entfernt',
	'emailext-watchedpage-article-renamed-subject' => '{{SITENAME}}: Der Artikel „$1“ wurde von $2 umbenannt',
	'emailext-watchedpage-article-deleted-subject' => '{{SITENAME}}: Der Artikel „$1“ wurde von $2 gelöscht',
	'emailext-watchedpage-article-protected' => "'''[$1 $2] auf [{{SERVER}} {{SITENAME}}] wurde geschützt. Sieh es dir an!'''",
	'emailext-watchedpage-article-unprotected' => "'''Von [$1 $2] auf [{{SERVER}} {{SITENAME}}] wurde der Schutz entfernt. Sieh es dir an!'''",
	'emailext-watchedpage-article-renamed' => "'''[$1 $2] auf [{{SERVER}} {{SITENAME}}] wurde umbenannt. Sieh es dir an!'''",
	'emailext-watchedpage-article-deleted' => "'''[$1 $2] auf [{{SERVER}} {{SITENAME}}] wurde gelöscht.'''",
	'emailext-watchedpage-deleted-button-text' => 'Versionsgeschichte ansehen',
);

$messages['es'] = array(
	'emailext-watchedpage-article-edited-subject' => '$1 en {{SITENAME}} ha sido editado por $2',
	'emailext-watchedpage-article-edited' => "'''[\$1 \$2] en [{{SERVER}} {{SITENAME}}] ha sido editado. ¡Revísalo!'\"",
	'emailext-watchedpage-diff-button-text' => 'Mostrar cambios',
	'emailext-watchedpage-article-link-text' => "[$1 Visita la página '''$2''' para ver qué hay de nuevo].",
	'emailext-watchedpage-view-all-changes' => "[$1 Ver todos los cambios realizados en '''$2'''].",
	'emailext-watchedpage-no-summary' => 'Resumen de ediciones no fue entregado',
	'emailext-watchedpage-subject-anonymous' => 'La página $1 en {{SITENAME}} ha sido editada',
	'emailext-watchedpage-article-protected-subject' => '$1 en {{SITENAME}} ha sido protegido por $2',
	'emailext-watchedpage-article-unprotected-subject' => '$1 en {{SITENAME}} ha sido desprotegido por $2',
	'emailext-watchedpage-article-renamed-subject' => '$1 en {{SITENAME}} ha sido renombrado por $2',
	'emailext-watchedpage-article-deleted-subject' => '$1 en {{SITENAME}} ha sido borrado por $2',
	'emailext-watchedpage-article-protected' => "'''[$1 $2] en [{{SERVER}} {{SITENAME}}] ha sido protegido. ¡Revísalo!'''",
	'emailext-watchedpage-article-unprotected' => "'''[$1 $2] en [{{SERVER}} {{SITENAME}}] ha sido desprotegido. ¡Revísalo!'''",
	'emailext-watchedpage-article-renamed' => "'''[$1 $2] en [{{SERVER}} {{SITENAME}}] ha sido renombrado ¡Revísalo!'''",
	'emailext-watchedpage-article-deleted' => "'''[$1 $2] en [{{SERVER}} {{SITENAME}}] ha sido borrado.'''",
	'emailext-watchedpage-deleted-button-text' => 'Ver el historial del artículo',
);

$messages['fr'] = array(
	'emailext-watchedpage-article-edited-subject' => '$2 a modifié $1 sur {{SITENAME}}',
	'emailext-watchedpage-article-edited' => "'''Quelqu'un a modifié [$1 $2] sur [{{SERVER}} {{SITENAME}}]. Consultez les modifications !'''",
	'emailext-watchedpage-diff-button-text' => 'Comparer les modifications',
	'emailext-watchedpage-article-link-text' => "[$1 Rendez-vous sur '''$2''' pour voir ce qui a été modifié]",
	'emailext-watchedpage-view-all-changes' => "[$1 Affichez toutes les modifications apportées à '''$2''']",
	'emailext-watchedpage-no-summary' => "Aucun résumé des modifications n'a été fourni.",
	'emailext-watchedpage-subject-anonymous' => 'Quelqu\'un a modifié 1 $ sur {{SITENAME}}.',
	'emailext-watchedpage-article-protected-subject' => '$2 a protégé $1 sur {{SITENAME}}',
	'emailext-watchedpage-article-unprotected-subject' => '$2 a déprotégé $1 sur {{SITENAME}}',
	'emailext-watchedpage-article-renamed-subject' => '$2 a renommé $1 sur {{SITENAME}}',
	'emailext-watchedpage-article-deleted-subject' => '$2 a supprimé $1 sur {{SITENAME}}',
	'emailext-watchedpage-article-protected' => "'''Quelqu'un a protégé [$1 $2] sur [{{SERVER}} {{SITENAME}}]. Consultez l'article !'''",
	'emailext-watchedpage-article-unprotected' => "'''Quelqu'un a déprotégé [$1 $2] sur [{{SERVER}} {{SITENAME}}]. Consultez l'article !'''",
	'emailext-watchedpage-article-renamed' => "'''Quelqu'un a renommé [$1 $2] sur [{{SERVER}} {{SITENAME}}]. Consultez l'article !'''",
	'emailext-watchedpage-article-deleted' => "'''Quelqu'un a supprimé [$1 $2] sur [{{SERVER}} {{SITENAME}}].'''",
	'emailext-watchedpage-deleted-button-text' => "Voir l'historique",
);

$messages['it'] = array(
	'emailext-watchedpage-article-edited-subject' => '$2 ha modificato $1 nella {{SITENAME}}',
	'emailext-watchedpage-article-edited' => "'''Qualcuno ha modificato [$1 $2] nella [{{SERVER}} {{SITENAME}}]. Dacci un'occhiata!'''",
	'emailext-watchedpage-diff-button-text' => 'Mostra cambiamenti',
	'emailext-watchedpage-article-link-text' => "[$1 Clicca su '''$2''' per vedere cosa c'è di nuovo]",
	'emailext-watchedpage-view-all-changes' => "[$1 Vedi tutte le modifiche a '''$2''']",
	'emailext-watchedpage-no-summary' => 'Non è stato fornito un riassunto delle modifiche',
	'emailext-watchedpage-subject-anonymous' => '$1 di {{SITENAME}} è stato modificato',
	'emailext-watchedpage-article-protected-subject' => '$2 ha protetto $1 nella {{SITENAME}}',
	'emailext-watchedpage-article-unprotected-subject' => '$2 ha tolto la protezione a $1 nella {{SITENAME}}',
	'emailext-watchedpage-article-renamed-subject' => '$2 ha cambiato titolo a $1 nella {{SITENAME}}',
	'emailext-watchedpage-article-deleted-subject' => '$2 ha eliminato $1 nella {{SITENAME}}',
	'emailext-watchedpage-article-protected' => "'''Qualcuno ha protetto [$1 $2] nella [{{SERVER}} {{SITENAME}}]. Dacci un'occhiata!'''",
	'emailext-watchedpage-article-unprotected' => "'''Qualcuno ha tolto la protezione a [$1 $2] nella [{{SERVER}} {{SITENAME}}]. Dacci un'occhiata!'''",
	'emailext-watchedpage-article-renamed' => "'''Qualcuno ha cambiato titolo a [$1 $2] nella [{{SERVER}} {{SITENAME}}]. Dacci un'occhiata!'''",
	'emailext-watchedpage-article-deleted' => "'''Qualcuno ha eliminato [$1 $2] nella [{{SERVER}} {{SITENAME}}].'''",
	'emailext-watchedpage-deleted-button-text' => "Vedi la cronologia dell'articolo",
);

$messages['ja'] = array(
	'emailext-watchedpage-article-edited-subject' => '$2さんが{{SITENAME}}の$1に編集を加えたようです',
	'emailext-watchedpage-article-edited' => "'''[{{SERVER}} {{SITENAME}}]の[$1 $2]に編集が加えられたようです。最新の記事をチェックしてみましょう！'''",
	'emailext-watchedpage-diff-button-text' => '変更を比較する',
	'emailext-watchedpage-article-link-text' => "[$1 '''$2'''にアクセスして最新の内容を確認する]",
	'emailext-watchedpage-view-all-changes' => "[$1 '''$2'''で行われたすべての変更を見る]",
	'emailext-watchedpage-no-summary' => '編集の要約はありません。',
	'emailext-watchedpage-subject-anonymous' => '{{SITENAME}}の「$1」に編集が加えられました',
	'emailext-watchedpage-article-protected-subject' => '$2さんが{{SITENAME}}の$1を保護したようです',
	'emailext-watchedpage-article-unprotected-subject' => '$2さんが{{SITENAME}}の$1の保護を解除したようです',
	'emailext-watchedpage-article-renamed-subject' => '$2さんが{{SITENAME}}の$1の名前を変更したようです',
	'emailext-watchedpage-article-deleted-subject' => '$2さんが{{SITENAME}}の$1を削除したようです',
	'emailext-watchedpage-article-protected' => "'''[{{SERVER}} {{SITENAME}}]の[$1 $2]が保護されたようです。チェックしてみましょう！'''",
	'emailext-watchedpage-article-unprotected' => "'''[{{SERVER}} {{SITENAME}}]の[$1 $2]の保護が解除されたようです。チェックしてみましょう！'''",
	'emailext-watchedpage-article-renamed' => "'''[{{SERVER}} {{SITENAME}}]の[$1 $2]の名前が変更されたようです。チェックしてみましょう！'''",
	'emailext-watchedpage-article-deleted' => "'''[{{SERVER}} {{SITENAME}}]の[$1 $2]が削除されたようです。'''",
	'emailext-watchedpage-deleted-button-text' => '記事の履歴を見る',
);

$messages['nl'] = array(
	'emailext-watchedpage-article-edited-subject' => '$1 on {{SITENAME}} has been edited by $2',
	'emailext-watchedpage-article-edited' => "'''[$1 $2] on [{{SERVER}} {{SITENAME}}] has been edited. Check it out!'''",
	'emailext-watchedpage-diff-button-text' => 'Compare changes',
	'emailext-watchedpage-article-link-text' => "[$1 Head over to '''$2''' to see what's new]",
	'emailext-watchedpage-view-all-changes' => "[$1 View all changes to '''$2''']",
	'emailext-watchedpage-no-summary' => 'No edit summary was given',
	'emailext-watchedpage-subject-anonymous' => '$1 on {{SITENAME}} has been edited',
	'emailext-watchedpage-article-protected-subject' => '$1 on {{SITENAME}} has been protected by $2',
	'emailext-watchedpage-article-unprotected-subject' => '$1 on {{SITENAME}} has been unprotected by $2',
	'emailext-watchedpage-article-renamed-subject' => '$1 on {{SITENAME}} has been renamed by $2',
	'emailext-watchedpage-article-deleted-subject' => '$1 on {{SITENAME}} has been deleted by $2',
	'emailext-watchedpage-article-protected' => "'''[$1 $2] on [{{SERVER}} {{SITENAME}}] has been protected. Check it out!'''",
	'emailext-watchedpage-article-unprotected' => "'''[$1 $2] on [{{SERVER}} {{SITENAME}}] has been unprotected. Check it out!'''",
	'emailext-watchedpage-article-renamed' => "'''[$1 $2] on [{{SERVER}} {{SITENAME}}] has been renamed. Check it out!'''",
	'emailext-watchedpage-article-deleted' => "'''[$1 $2] on [{{SERVER}} {{SITENAME}}] has been deleted.'''",
	'emailext-watchedpage-deleted-button-text' => 'See article history',
);

$messages['pl'] = array(
	'emailext-watchedpage-article-edited-subject' => 'Użytkownik $2 dokonał edycji $1 na {{SITENAME}}',
	'emailext-watchedpage-article-edited' => "'''Dokonano edycji [$1 $2] na [{{SERVER}} {{SITENAME}}]. Sprawdź!'''",
	'emailext-watchedpage-diff-button-text' => 'Porównaj zmiany',
	'emailext-watchedpage-article-link-text' => "[$1 Przejdź do '''$2''' i zobacz co się zmieniło]",
	'emailext-watchedpage-view-all-changes' => "[$1 Zobacz wszystkie zmiany '''$2''']",
	'emailext-watchedpage-no-summary' => 'Brak podsumowania zmian',
	'emailext-watchedpage-subject-anonymous' => 'Dokonano edycji $1 na {{SITENAME}}',
	'emailext-watchedpage-article-protected-subject' => 'Użytkownik $2 zabezpieczył $1 na {{SITENAME}}',
	'emailext-watchedpage-article-unprotected-subject' => 'Użytkownik $2 usunął zabezpieczenie $1 na {{SITENAME}}',
	'emailext-watchedpage-article-renamed-subject' => 'Użytkownik $2 zmienił nazwę $1 na {{SITENAME}}',
	'emailext-watchedpage-article-deleted-subject' => 'Użytkownik $2 usunął $1 na {{SITENAME}}',
	'emailext-watchedpage-article-protected' => "'''Zabezpieczono [$1 $2] na [{{SERVER}} {{SITENAME}}]. Sprawdź!'''",
	'emailext-watchedpage-article-unprotected' => "'''Usunięto zabezpieczenie [$1 $2] na [{{SERVER}} {{SITENAME}}]. Sprawdź!'''",
	'emailext-watchedpage-article-renamed' => "'''Dokonano zmiany nazwy [$1 $2] na [{{SERVER}} {{SITENAME}}]. Sprawdź!'''",
	'emailext-watchedpage-article-deleted' => "'''Usunięto [$1 $2] na [{{SERVER}} {{SITENAME}}]. Sprawdź!'''",
	'emailext-watchedpage-deleted-button-text' => 'Zobacz historię artykułu',
);

$messages['pt'] = array(
	'emailext-watchedpage-article-edited-subject' => '$1 foi editado por $2 na {{SITENAME}}',
	'emailext-watchedpage-article-edited' => "'''[$1 $2] na [{{SERVER}} {{SITENAME}}] foi editado. Confira!'''",
	'emailext-watchedpage-diff-button-text' => 'Comparar mudanças',
	'emailext-watchedpage-article-link-text' => "[$1 Vá para '''$2''' para ver o que há de novo]",
	'emailext-watchedpage-view-all-changes' => "[$1 Visualizar todas as alterações de '''$2''']",
	'emailext-watchedpage-no-summary' => 'Não foi dado nenhum resumo',
	'emailext-watchedpage-subject-anonymous' => '$1 na {{SITENAME}} foi editado',
	'emailext-watchedpage-article-protected-subject' => '$1 foi protegido por $2 na {{SITENAME}}',
	'emailext-watchedpage-article-unprotected-subject' => '$1 foi desprotegido por $2 na {{SITENAME}}',
	'emailext-watchedpage-article-renamed-subject' => '$1 foi renomeado por $2 na {{SITENAME}}',
	'emailext-watchedpage-article-deleted-subject' => '$1 foi excluído por $2 na {{SITENAME}}',
	'emailext-watchedpage-article-protected' => "'''[$1 $2] na [{{SERVER}} {{SITENAME}}] foi protegido. Confira!'''",
	'emailext-watchedpage-article-unprotected' => "'''[$1 $2] na [{{SERVER}} {{SITENAME}}] foi desprotegido. Confira!'''",
	'emailext-watchedpage-article-renamed' => "'''[$1 $2] na [{{SERVER}} {{SITENAME}}] foi renomeado. Confira!'''",
	'emailext-watchedpage-article-deleted' => "'''[$1 $2] na [{{SERVER}} {{SITENAME}}] foi excluído.'''",
	'emailext-watchedpage-deleted-button-text' => 'Ver o histórico do artigo',
);

$messages['ru'] = array(
	'emailext-watchedpage-article-edited-subject' => '$2 отредактировал(а) страницу $1 на {{SITENAME}}',
	'emailext-watchedpage-article-edited' => "'''Страница [$1 $2] на [{{SERVER}} {{SITENAME}}] была отредактирована. Посмотрите правки!'''",
	'emailext-watchedpage-diff-button-text' => 'Сравнить изменения',
	'emailext-watchedpage-article-link-text' => "[$1 Для просмотра новых правок перейдите к «'''$2'''».]",
	'emailext-watchedpage-view-all-changes' => "[$1 Просмотрите все правки статьи «'''$2'''».]",
	'emailext-watchedpage-no-summary' => 'Участник не дал пояснений к данной правке.',
	'emailext-watchedpage-subject-anonymous' => 'Страница «$1» на {{SITENAME}} была отредактирована',
	'emailext-watchedpage-article-protected-subject' => '$2 установил(а) защиту страницы $1 на {{SITENAME}}',
	'emailext-watchedpage-article-unprotected-subject' => '$2 изменил(а) защиту страницы $1 на {{SITENAME}}',
	'emailext-watchedpage-article-renamed-subject' => '$2 переименовал(а) страницу $1 на {{SITENAME}}',
	'emailext-watchedpage-article-deleted-subject' => '$2 удалил(а) страницу $1 на {{SITENAME}}',
	'emailext-watchedpage-article-protected' => "'''Страница [$1 $2] на [{{SERVER}} {{SITENAME}}] была защищена. Посмотрите сами!'''",
	'emailext-watchedpage-article-unprotected' => "'''Изменена защита для страницы [$1 $2] на [{{SERVER}} {{SITENAME}}]. Посмотрите сами!'''",
	'emailext-watchedpage-article-renamed' => "'''Страница [$1 $2] на [{{SERVER}} {{SITENAME}}] была переименована. Посмотрите сами!'''",
	'emailext-watchedpage-article-deleted' => "'''Страница [$1 $2] на [{{SERVER}} {{SITENAME}}] была удалена.'''",
	'emailext-watchedpage-deleted-button-text' => 'Просмотреть историю статьи',
);

$messages['zh-hans'] = array(
	'emailext-watchedpage-article-edited-subject' => '{{SITENAME}}网站上题为$1的文章已被$2编辑',
	'emailext-watchedpage-article-edited' => "'''[{{SERVER}} {{SITENAME}}]网站上题为[$1 $2]的文章已被编辑。快来查看吧！'''",
	'emailext-watchedpage-diff-button-text' => '查看更改之处',
	'emailext-watchedpage-article-link-text' => "[$1 前往'''$2'''查看新内容]",
	'emailext-watchedpage-view-all-changes' => "[$1 查看对'''$2'''所做的所有更改]",
	'emailext-watchedpage-no-summary' => '没有编辑概要',
	'emailext-watchedpage-subject-anonymous' => '{{SITENAME}}上的$1已被编辑过',
	'emailext-watchedpage-article-protected-subject' => '{{SITENAME}}网站上题为$1的文章已被$2保护',
	'emailext-watchedpage-article-unprotected-subject' => '{{SITENAME}}网站上题为$1的文章已被$2取消保护',
	'emailext-watchedpage-article-renamed-subject' => '{{SITENAME}}网站上题为$1的文章已被$2重命名',
	'emailext-watchedpage-article-deleted-subject' => '{{SITENAME}}网站上题为$1的文章已被$2删除',
	'emailext-watchedpage-article-protected' => "'''[{{SERVER}} {{SITENAME}}]网站上题为[$1 $2]的文章已被保护。快来查看吧！'''",
	'emailext-watchedpage-article-unprotected' => "'''[{{SERVER}} {{SITENAME}}]网站上题为[$1 $2]的文章已被取消保护。快来查看吧！'''",
	'emailext-watchedpage-article-renamed' => "'''[{{SERVER}} {{SITENAME}}]网站上题为[$1 $2]的文章已被重新命名。快来查看吧！'''",
	'emailext-watchedpage-article-deleted' => "'''[{{SERVER}} {{SITENAME}}]网站上题为[$1 $2]的文章已被删除。'''",
	'emailext-watchedpage-deleted-button-text' => '查看文章历史记录',
);

$messages['zh-tw'] = array(
	'emailext-watchedpage-article-edited-subject' => '{{SITENAME}}網站上題爲$1的文章已被$2編輯',
	'emailext-watchedpage-article-edited' => "'''[{{SERVER}} {{SITENAME}}]網站上題爲[$1 $2]的文章已被編輯。快來查看吧！'''",
	'emailext-watchedpage-diff-button-text' => '查看更改之處',
	'emailext-watchedpage-article-link-text' => "[$1 前往'''$2'''查看新内容]",
	'emailext-watchedpage-view-all-changes' => "[$1 查看对'''$2'''所做的所有更改]",
	'emailext-watchedpage-no-summary' => '沒有編輯概要',
	'emailext-watchedpage-subject-anonymous' => '{{SITENAME}}上的$1已經被編輯過',
	'emailext-watchedpage-article-protected-subject' => '{{SITENAME}}網站上題爲$1的文章已被$2保護',
	'emailext-watchedpage-article-unprotected-subject' => '{{SITENAME}}網站上題爲$1的文章已被$2取消保護',
	'emailext-watchedpage-article-renamed-subject' => '{{SITENAME}}網站上題爲$1的文章已被$2重新命名',
	'emailext-watchedpage-article-deleted-subject' => '{{SITENAME}}網站上題爲$1的文章已被$2刪除',
	'emailext-watchedpage-article-protected' => "'''[{{SERVER}} {{SITENAME}}]網站上題爲[$1 $2]的文章已被保護。快來查看吧！'''",
	'emailext-watchedpage-article-unprotected' => "'''[{{SERVER}} {{SITENAME}}]網站上題爲[$1 $2]的文章已被取消保護。快來查看吧！'''",
	'emailext-watchedpage-article-renamed' => "'''[{{SERVER}} {{SITENAME}}]網站上題爲[$1 $2]的文章已被重新命名。快來查看吧！'''",
	'emailext-watchedpage-article-deleted' => "'''[{{SERVER}} {{SITENAME}}]網站上題爲[$1 $2]的文章已被刪除。'''",
	'emailext-watchedpage-deleted-button-text' => '查看文章紀錄',
);

