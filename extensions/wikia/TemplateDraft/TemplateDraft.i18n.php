<?php
$messages = array();

$messages['en'] = array(
	'templatedraft-description' => 'TemplateDraft extension',
	'right-templatedraft' => 'Allows access to a wizard that helps convert non-portable infoboxes to the new markup',
	'templatedraft-subpage' => 'Draft',
	'templatedraft-editintro' => "Here you go! We've generated a draft version of your infobox with our new markup. We'll save it as a sub-page so you can review it and make any needed changes. You may want to $1 or $2.",
	'templatedraft-approval-no-page-error' => "Approval failed as draft page doesn't exist",
	'templatedraft-approval-no-templatedraft-error' => 'Approve draft action is not applicable on non template draft pages',
	'templatedraft-approval-success-confirmation' => 'This template contents was replaced with updated version from draft template and the draft was removed',
	'templatedraft-approval-summary' => 'Infobox updated using the [[Help:PortableInfoboxes|portable infobox]] migration tool',
	'templatedraft-draft-removal-summary' => 'Cleanup. Draft approved to parent page.',
	'templatedraft-module-title-create' => 'Migrate this infobox',
	'templatedraft-module-subtitle-create' => 'This template does not use the new [[Help:PortableInfoboxes|infobox markup]].',
	'templatedraft-module-content-create' => 'We can generate a draft version of the markup from your existing infobox and save it as a sub-page so you can review it and make any needed changes.',
	'templatedraft-module-button-create' => 'Generate draft markup',
	'templatedraft-module-button-title-create' => 'Open a new tab with a pre-filled edit form',
	'templatedraft-module-title-approve' => 'Move this draft template',
	'templatedraft-module-content-approve' => 'Happy with this draft and want to promote it to the live template?',
	'templatedraft-module-button-approve' => 'Approve this draft',
	'templatedraft-module-approve-protected' => 'This template is protected. Please ask an [[Special:ListAdmins|Admin]] to approve this draft.',
	'templatedraft-preview-n-docs' => '== Usage & preview ==
Type in this:

<pre>
$1
</pre>

to see this:

$2

[{{fullurl:{{ns:Template}}:{{PAGENAME}}}}?action=purge Click here to refresh the preview above]',
	'templatedraft-preview-example-value' => 'This is a test',
	'templatedraft-module-editintro-please-convert' => 'We can generate a draft version of your infobox with our new markup just click $1.',
	'templatedraft-module-view-parent' => 'view parent template wikitext',
	'templatedraft-module-help' => 'view the help page on Infobox markup',
	'templatedraft-invalid-template' => 'Invalid template name provided.',
	'templatedraft-protect-edit' => 'You do not have permission to edit parent page.',
);

$messages['qqq'] = array(
	'templatedraft-description' => '{{desc}}',
	'templatedraft-subpage' => 'A name that should be used for subpages of templates that contain a draft content.',
	'templatedraft-editintro' => 'Message informing user that a new sub-page with draft version of infobox with new markup was created and user can review it and make any changes. Params: $1 is a link to the help page for the new infobox markup and $2 is a link to the parent template page.',
	'templatedraft-approval-no-page-error' => 'Error message displayed on banner notification when approval failed due to not existent draft page',
	'templatedraft-approval-no-templatedraft-error' => 'Error message displayed on banner notification when approval failed due to action performed on non draft page',
	'templatedraft-approval-success-confirmation' => 'Message dispalyed on banner notification informing user that template contents was successful replaced by template draft contents and the draft was removed.',
	'templatedraft-approval-summary' => 'Text used as edit summary when code is automatically replacing template with content from draft template on user approval',
	'templatedraft-draft-removal-summary' => 'Text used as delete summary on draft page removal after draft page was approved to parent page',
	'templatedraft-module-title-create' => 'A title of the TemplateDraft module for creating draft that appears in the right rail on Template pages.',
	'templatedraft-module-subtitle-create' => 'A title of the TemplateDraft module for creating draft that appears in the right rail on Template pages.',
	'templatedraft-module-content-create' => 'A content of the TemplateDraft module for creating draft that appears in the right rail on Template pages.',
	'templatedraft-module-button-create' => 'A button shown in a right rail module for creating draft that gets user to a subpage with a draft of a template.',
	'templatedraft-module-button-title-create' => 'Title of the "Generate draft markup" button. It should tell users what will happen when they click it.',
	'templatedraft-module-title-approve' => 'A title of the TemplateDraft module for approving draft that appears in the right rail on Template pages.',
	'templatedraft-module-content-approve' => 'A content of the TemplateDraft module for approving draft that appears in the right rail on Template pages.',
	'templatedraft-module-button-approve' => 'A button shown in a right rail module for approving draft that moves draft text to parent template and gets user to this parent template',
	'templatedraft-module-approve-protected' => 'Message informing user that template is protected and to approve it should contact one of the admins.',
	'templatedraft-preview-n-docs' => 'Used when generating documentation for a converted draft of a template',
	'templatedraft-preview-example-value' => 'Example attribute value used when generating documentation for a converted draft of a template',
	'templatedraft-module-editintro-please-convert' => 'Information for user that a draft version of infobox with new markup can be generated automatically by clicking button ($1).',
	'templatedraft-module-view-parent' => 'Link label to view parent page of this draft',
	'templatedraft-module-help' => 'Link label to view the help page on Infobox markup',
	'templatedraft-invalid-template' => 'Error message returned by an API method when an invalid or non-existent title was provided.',
	'templatedraft-protect-edit' => 'Error message informing user does not have permissions to edit parent page.',
);

$messages['de'] = array(
	'templatedraft-description' => 'TemplateDraft-Erweiterung',
	'templatedraft-subpage' => 'Entwurf',
	'templatedraft-editintro' => 'Bitteschön! Wir haben eine Entwurfsversion deiner Infobox in unserem neuen Format erstellt. Wir speichern sie als Unterseite, damit du sie überprüfen und alle notwendigen Änderungen vornehmen kannst. Schau auch $1 und $2 an.',
	'templatedraft-approval-no-page-error' => 'Übernahme fehlgeschlagen, da die Entwurfsseite nicht existiert',
	'templatedraft-approval-no-templatedraft-error' => 'Diese Seite ist kein Vorlagenentwurf und kann daher nicht übernommen werden.',
	'templatedraft-approval-success-confirmation' => 'Der Inhalt dieser Vorlage wurde mit der aktualisierten Version aus dem Vorlagenentwurf ersetzt und der Entwurf wurde entfernt.',
	'templatedraft-approval-summary' => 'Die Infobox wurde mithilfe des [[Hilfe:Umwandlung von Infoboxen|Umwandlungswerkzeugs]] aktualisiert.',
	'templatedraft-draft-removal-summary' => 'Aufgeräumt. Der Entwurf wurde auf die übergeordnete Vorlagenseite übernommen.',
	'templatedraft-module-title-create' => 'Diese Infobox umwandeln',
	'templatedraft-module-subtitle-create' => 'Diese Vorlage verwendet nicht das neue [[Hilfe:Infoboxen|Infobox-Format]].',
	'templatedraft-module-content-create' => 'Wir können eine Entwurfsversion der Vorlage im neuen Format aus deiner bestehenden Infobox erstellen und diese als Unterseite speichern. Du kannst sie dann überprüfen und alle notwendigen Änderungen vornehmen.',
	'templatedraft-module-button-create' => 'Entwurf im neuen Format erstellen',
	'templatedraft-module-button-title-create' => 'Öffnet einen neuen Browsertab mit vorgefülltem Bearbeitungsformular',
	'templatedraft-module-title-approve' => 'Diesen Vorlagenentwurf verschieben',
	'templatedraft-module-content-approve' => 'Bist du mit diesem Entwurf zufrieden und möchtest ihn übernehmen?',
	'templatedraft-module-button-approve' => 'Diesen Entwurf übernehmen',
	'templatedraft-preview-n-docs' => '== Verwendung und Vorschau ==
Gib das ein:

<pre>
$1
</pre>

um das zu sehen:

$2

[{{fullurl:{{ns:Template}}:{{PAGENAME}}}}?action=purge Klicke hier, um die obige Vorschau zu aktualisieren]',
	'templatedraft-module-editintro-please-convert' => 'Wir können eine Entwurfsversion deiner Infobox in unserem neuen Format erstellen. Klicke dazu einfach auf $1.',
	'templatedraft-module-view-parent' => 'den Wikitext der übergeordneten Vorlage',
	'templatedraft-module-help' => 'die Hilfeseite für das Infobox-Format',
	'templatedraft-invalid-template' => 'Ungültiger Vorlagenname angegeben.',
	'templatedraft-module-approve-protected' => 'Diese Vorlage ist geschützt. Wende dich bitte an einen [[Special:ListAdmins|Administrator]], damit er diesen Entwurf freischalten kann.',
	'templatedraft-protect-edit' => 'Du hast keine Berechtigung, die übergeordnete Vorlagenseite zu bearbeiten.',
	'right-templatedraft' => 'Ermöglicht den Zugriff auf einen Assistenten, der hilft, die nicht portablen Infoboxen ins neue Format umzuwandeln',
	'templatedraft-preview-example-value' => 'Dies ist ein Test',
);

$messages['es'] = array(
	'templatedraft-description' => 'Extensión TemplateDraft',
	'templatedraft-subpage' => 'Borrador',
	'templatedraft-editintro' => '¡Aquí tienes! Hemos generado un borrador de tu infobox con nuestro nuevo marcador. Lo guardaremos como una subpágina para que puedas revisarlo y realizar cualquier cambio necesario. Tal vez desees $1 o $2.',
	'templatedraft-approval-no-page-error' => 'No se pudo aprobar porque la página de borrador no existe',
	'templatedraft-approval-no-templatedraft-error' => 'Esta página no es un borrador de plantilla y por lo tanto no se puede aprobar',
	'templatedraft-approval-success-confirmation' => 'El contenido de esta platilla se cambió con una versión actualizada de una plantilla de borrador y se eliminó el borrador',
	'templatedraft-approval-summary' => 'El Infobox se actualizó usando la herramienta de migración de [[w:c:comunidad:Ayuda:Infoboxes|infobox portátil]]',
	'templatedraft-draft-removal-summary' => 'Limpieza. Borrador aprobado para la página principal.',
	'templatedraft-module-title-create' => 'Migrar esta infobox',
	'templatedraft-module-subtitle-create' => 'Esta plantilla no usa el nuevo [[w:c:comunidad:Ayuda:Infoboxes|marcador de infobox]].',
	'templatedraft-module-content-create' => 'Podemos generar un borrador del marcador desde tu infobox existente y guardarlo como subpágina, para que puedas revisarlo y hacer cualquier cambio necesario.',
	'templatedraft-module-button-create' => 'Generar marcador de borrador',
	'templatedraft-module-button-title-create' => 'Abrir una nueva pestaña con un formulario de edición previamente llenado',
	'templatedraft-module-title-approve' => 'Mover esta plantilla de borrador',
	'templatedraft-module-content-approve' => '¿Estás conforme con este borrador y deseas promoverlo a una plantilla activa?',
	'templatedraft-module-button-approve' => 'Aprobar este borrador',
	'templatedraft-preview-n-docs' => '== Uso y previsualización ==
Escribe lo siguiente:

<pre>
$1
</pre>

para ver esto:

$2

[{{fullurl:{{ns:Template}}:{{PAGENAME}}}}?action=purge Haz clic aquí para renovar la previsualización anterior]',
	'templatedraft-module-editintro-please-convert' => 'Podemos generar un borrador de tu infobox con nuestro nuevo marcador. Solo haz clic en $1.',
	'templatedraft-module-view-parent' => 'ver wikitext de la plantilla principal',
	'templatedraft-module-help' => 'ver la página de ayuda sobre el marcador del infobox',
	'templatedraft-invalid-template' => 'El nombre de la plantilla es inválido.',
	'templatedraft-module-approve-protected' => 'Esta plantilla está protegida. Por favor pregunta a un [[{{#Special:ListAdmins}}|administrador]] que apruebe este borrador.',
	'templatedraft-protect-edit' => 'No tienes permiso para editar la página principal.',
	'right-templatedraft' => 'Permite el acceso a un asistente que ayudará a convertir infoboxes no portátiles al nuevo marcador',
	'templatedraft-preview-example-value' => 'Esta es una prueba',
);

$messages['fr'] = array(
	'templatedraft-description' => 'Extension TemplateDraft',
	'templatedraft-subpage' => 'Version de travail',
	'templatedraft-editintro' => "Eh voilà ! Nous avons généré une version de travail de votre infobox avec notre nouveau code. Nous allons l'enregistrer comme sous-page afin que vous puissiez la vérifier et y apporter d'éventuelles modifications. Vous voudrez peut-être $1 ou $2.",
	'templatedraft-approval-no-page-error' => "Échec d'approbation : page de la version de travail inexistante",
	'templatedraft-approval-no-templatedraft-error' => "Impossible d'approuver une version de travail qui ne concerne pas un modèle",
	'templatedraft-approval-success-confirmation' => 'Le contenu de ce modèle a été remplacé par la version mise à jour du modèle de la version de travail et la version de travail a été supprimée.',
	'templatedraft-approval-summary' => "Infobox mise à jour à l'aide de l'outil de migration des [[w:c:fr:Aide:Infoboxes_portables|infoboxes portables]]",
	'templatedraft-draft-removal-summary' => 'Nettoyage. Application de la version de travail sur la page parente approuvée.',
	'templatedraft-module-title-create' => 'Migrer cette infobox',
	'templatedraft-module-subtitle-create' => "Le nouveau [[w:c:fr:Aide:Infoboxes_portables|code des infoboxes]] n'est pas utilisé pour ce modèle.",
	'templatedraft-module-content-create' => "Nous pouvons générer une version de travail de votre infobox avec le nouveau code et l'enregistrer comme sous-page afin que vous puissiez la vérifier et y apporter d'éventuelles modifications.",
	'templatedraft-module-button-create' => 'Générer le code de la version de travail',
	'templatedraft-module-button-title-create' => "Ouvrir un nouvel onglet avec un formulaire d'édition pré-rempli",
	'templatedraft-module-title-approve' => 'Déplacer ce modèle de la version de travail',
	'templatedraft-module-content-approve' => "Cette version de travail vous satisfait et vous souhaitez l'appliquer au modèle en cours d'utilisation ?",
	'templatedraft-module-button-approve' => 'Approuver cette version de travail',
	'templatedraft-preview-n-docs' => "== Utilisation et aperçu ==
Tapez ceci :

<pre>
$1
</pre>

pour afficher ceci :

$2

[{{fullurl:{{ns:Template}}:{{PAGENAME}}}}?action=purge Cliquez ici pour actualiser l'aperçu ci-dessus.]",
	'templatedraft-module-editintro-please-convert' => 'Nous pouvons générer une version de travail de votre infobox avec notre nouveau code. Il vous suffit de cliquer sur $1.',
	'templatedraft-module-view-parent' => 'afficher le wikitexte du modèle parent',
	'templatedraft-module-help' => "afficher la page d'aide sur le code des infoboxes",
	'templatedraft-invalid-template' => 'Nom de modèle fourni non valide.',
	'templatedraft-module-approve-protected' => "Ce modèle est protégé. Veuillez demander à un [[Special:ListAdmins|administrateur]] d'approuver cette version de travail.",
	'templatedraft-protect-edit' => "Vous n'êtes pas autorisé à modifier la page parente.",
	'right-templatedraft' => 'Permet d’accéder à un assistant qui vous aidera à convertir les infoboxes non portables au nouveau balisage',
	'templatedraft-preview-example-value' => 'Ceci est un test',
);

$messages['it'] = array(
	'templatedraft-description' => 'TemplateDraft extension',
	'templatedraft-subpage' => 'Bozza',
	'templatedraft-editintro' => 'Ecco qua! Abbiamo generato una bozza del tuo infobox con il nuovo markup. La salveremo come sottopagina in modo che tu possa rivederla e fare tutte le modifiche necessarie. Puoi fare anche riferimento a $1 o $2.',
	'templatedraft-approval-no-page-error' => 'Approvazione fallita: la bozza della pagina non esiste',
	'templatedraft-approval-no-templatedraft-error' => 'Impossibile approvare questa pagina in quanto non è la bozza di un template',
	'templatedraft-approval-success-confirmation' => 'I contenuti di questo template sono stati sostituiti da una versione aggiornata della bozza del template e la bozza è stata rimossa',
	'templatedraft-approval-summary' => 'Infobox aggiornato usando lo strumento di migrazione degli [[w:it:Aiuto:Infobox portatili|infobox portatili]]',
	'templatedraft-draft-removal-summary' => 'Pulizia. Bozza approvata per la pagina madre.',
	'templatedraft-module-title-create' => 'Converti questo infobox',
	'templatedraft-module-subtitle-create' => 'Questo template non usa il nuovo [[w:it:Aiuto:Infobox|markup per gli infobox]].',
	'templatedraft-module-content-create' => 'Possiamo generare una bozza del markup dal tuo infobox esistente e salvarla come sottopagina in modo che tu possa rivederla e fare tutte le modifiche necessarie.',
	'templatedraft-module-button-create' => 'Genera markup di bozza',
	'templatedraft-module-button-title-create' => 'Apri una nuova scheda con un modulo di modifica precompilato',
	'templatedraft-module-title-approve' => 'Sposta questo template di bozza',
	'templatedraft-module-content-approve' => 'Sei soddisfatto di questa bozza e desideri farla comparire nel template corrente?',
	'templatedraft-module-button-approve' => 'Approva questa bozza',
	'templatedraft-preview-n-docs' => "== Uso e anteprima ==
Digita:

<pre>
$1
</pre>

per vedere:

$2

[{{fullurl:{{ns:Template}}:{{PAGENAME}}}}?action=purge Clicca qui per aggiornare l'anteprima precedente]",
	'templatedraft-module-editintro-please-convert' => 'Possiamo generare una bozza del tuo infobox con il nuovo markup se clicchi qui $1.',
	'templatedraft-module-view-parent' => 'vedi wikitext del template padre',
	'templatedraft-module-help' => 'vedi la pagina di aiuto sul markup degli Infobox',
	'templatedraft-invalid-template' => 'Il nome del template fornito non è valido.',
	'templatedraft-module-approve-protected' => 'Questo template è protetto. Chiedi ad un [[Special:ListAdmins|amministratore]] di approvare questo progetto.',
	'templatedraft-protect-edit' => 'Non hai il permesso di modificare la pagina madre.',
	'right-templatedraft' => "Consente l'accesso ad una procedura guidata che aiuta nella conversione degli infobox al nuovo markup",
	'templatedraft-preview-example-value' => 'Questo è un test',
);

$messages['ja'] = array(
	'templatedraft-description' => 'テンプレートドラフト拡張機能',
	'templatedraft-subpage' => 'ドラフト',
	'templatedraft-editintro' => '新しいマークアップを使用したインフォボックスのドラフト版を作成しました。サブページとして保存されますので、内容を確認し、必要に応じて変更を加えていただけます。$1または$2もご覧ください。',
	'templatedraft-approval-no-page-error' => 'ドラフトページが存在しないため、採用できませんでした',
	'templatedraft-approval-no-templatedraft-error' => 'テンプレートのドラフトページ以外でドラフトの採用を行うことはできません',
	'templatedraft-approval-success-confirmation' => 'このテンプレートのコンテンツをドラフト・テンプレートの更新版と置き換え、ドラフトを削除しました',
	'templatedraft-approval-summary' => '[[Help:PortableInfoboxes|ポータブル・インフォボックス]]移行ツールを使用してインフォボックスを更新しました',
	'templatedraft-draft-removal-summary' => 'クリーンアップ。ドラフトを親ページに採用しました。',
	'templatedraft-module-title-create' => 'このインフォボックスを移行',
	'templatedraft-module-subtitle-create' => 'このテンプレートは、新しい[[Help:PortableInfoboxes|インフォボックスのマークアップ]]を使用していません。',
	'templatedraft-module-content-create' => '既存のインフォボックスからマークアップのドラフト版を生成するとサブページとして保存されるので、内容を確認しながら必要に応じて変更を加えることができます。',
	'templatedraft-module-button-create' => 'マークアップのドラフトを生成する',
	'templatedraft-module-button-title-create' => '新しいタブに入力済みの編集フォームを開く',
	'templatedraft-module-title-approve' => 'このドラフト・テンプレートを移動',
	'templatedraft-module-content-approve' => 'このドラフトをテンプレートとして採用しますか？',
	'templatedraft-module-button-approve' => 'このドラフトを採用する',
	'templatedraft-preview-n-docs' => '==使い方とプレビュー==
次を入力します。

<pre>
$1
</pre>

下のように表示されます。

$2

[{{fullurl:{{ns:Template}}:{{PAGENAME}}}}?action=purge ここをクリックすると上のプレビューを更新できます]',
	'templatedraft-module-editintro-please-convert' => '「$1」をクリックすると、新しいマークアップを使用したインフォボックスのドラフト版を生成できます。',
	'templatedraft-module-view-parent' => 'もとのテンプレートのWikiテキスト',
	'templatedraft-module-help' => 'インフォボックスのマークアップに関するヘルプページを見る',
	'templatedraft-invalid-template' => '入力したテンプレート名は無効です。',
	'templatedraft-module-approve-protected' => 'このテンプレートは保護されているようです。このドラフトを承認するには、[[Special:ListAdmins|アドミン]]にお問い合わせください。',
	'templatedraft-protect-edit' => '親ページを編集していただくための権限がありません。',
	'right-templatedraft' => '新しいマークアップを使用したインフォボックスへの変換を補助するウィザードを許可する',
	'templatedraft-preview-example-value' => 'これはテストです',
);

$messages['ko'] = array(
	'templatedraft-editintro' => '성공적으로 변환이 완료되었습니다. 새 정보상자는 기존 정보상자의 하위문서로 저장되며 언제든지 추가적으로 수정하실 수 있습니다. 또, $1 또는 $2을 확인해 보시는 건 어떨까요?',
	'templatedraft-module-button-create' => '초안 생성하기',
	'templatedraft-module-content-create' => '기존의 정보상자를 간편 정보상자로 변환해 초안을 만들어드릴 수 있습니다. 변환된 초안은 이 틀의 하위문서에 저장되며 필요에 따라 추가적으로 수정하시면 됩니다.',
	'templatedraft-module-help' => '간편 정보상자에 대한 도움말',
	'templatedraft-module-subtitle-create' => '현재 이 틀은 [[도움말:간편 정보상자|간편 정보상자]]를 사용하고 있지 않습니다.',
	'templatedraft-module-title-create' => '정보상자를 변환하세요',
	'templatedraft-module-view-parent' => '기존 정보상자의 위키문법',
	'templatedraft-preview-n-docs' => '== 사용법 및 예제 ==
사용법은 다음과 같습니다.

<pre>
$1
</pre>

예제는 다음과 같습니다.

$2

[{{fullurl:{{ns:Template}}:{{PAGENAME}}}}?action=purge 이곳을 눌러 예제를 새로 고침하세요.]',
	'templatedraft-subpage' => '초안',
);

$messages['nl'] = array(
	'templatedraft-description' => 'TemplateDraft extension',
	'templatedraft-subpage' => 'Draft',
	'templatedraft-editintro' => "Here you go! We've generated a draft version of your infobox with our new markup. We'll save it as a sub-page so you can review it and make any needed changes. You may want to $1 or $2.",
	'templatedraft-approval-no-page-error' => "Approval failed as draft page doesn't exist",
	'templatedraft-approval-no-templatedraft-error' => 'Approve draft action is not applicable on non template draft pages',
	'templatedraft-approval-success-confirmation' => 'This template contents was replaced with updated version from draft template and the draft was removed',
	'templatedraft-approval-summary' => 'Infobox updated using the [[Help:PortableInfoboxes|portable infobox]] migration tool',
	'templatedraft-draft-removal-summary' => 'Cleanup. Draft approved to parent page.',
	'templatedraft-module-title-create' => 'Migrate this infobox',
	'templatedraft-module-subtitle-create' => 'This template does not use the new [[Help:PortableInfoboxes|infobox markup]].',
	'templatedraft-module-content-create' => 'We can generate a draft version of the markup from your existing infobox and save it as a sub-page so you can review it and make any needed changes.',
	'templatedraft-module-button-create' => 'Generate draft markup',
	'templatedraft-module-button-title-create' => 'Open a new tab with a pre-filled edit form',
	'templatedraft-module-title-approve' => 'Move this draft template',
	'templatedraft-module-content-approve' => 'Happy with this draft and want to promote it to the live template?',
	'templatedraft-module-button-approve' => 'Approve this draft',
	'templatedraft-preview-n-docs' => '== Usage & preview ==
Type in this:

<pre>
$1
</pre>

to see this:

$2

[{{fullurl:{{ns:Template}}:{{PAGENAME}}}}?action=purge Click here to refresh the preview above]',
	'templatedraft-module-editintro-please-convert' => 'We can generate a draft version of your infobox with our new markup just click $1.',
	'templatedraft-module-view-parent' => 'view parent template wikitext',
	'templatedraft-module-help' => 'view the help page on Infobox markup',
	'templatedraft-invalid-template' => 'Invalid template name provided.',
	'templatedraft-module-approve-protected' => 'This template is protected. Please ask an [[Special:ListAdmins|Admin]] to approve this draft.',
	'templatedraft-protect-edit' => 'You do not have permission to edit parent page.',
	'right-templatedraft' => 'Allows access to a wizard that helps convert non-portable infoboxes to the new markup',
	'templatedraft-preview-example-value' => 'This is a test',
);

$messages['pl'] = array(
	'templatedraft-description' => 'Rozszerzenie TemplateDraft',
	'templatedraft-subpage' => 'szkic',
	'templatedraft-editintro' => 'Proszę bardzo! Wygenerowaliśmy wersję roboczą twojego infoboksu wykorzystując nasze nowe znaczniki. Zapiszemy go jako podstronę, co umożliwi jego przejrzenie i wprowadzenie niezbędnych zmian. Jeśli chcesz, zajrzyj na $1 lub do $2.',
	'templatedraft-approval-no-page-error' => 'Zatwierdzenie nie powiodło się, ponieważ strona ze szkicem nie istnieje',
	'templatedraft-approval-no-templatedraft-error' => 'Zatwierdzenie wersji roboczej nie jest możliwe na stronach szkiców, które nie są szablonami',
	'templatedraft-approval-success-confirmation' => 'Zawartość tego szablonu została zastąpiona zaktualizowaną wersją ze szkicu, a ten został usunięty.',
	'templatedraft-approval-summary' => 'Infoboks został uaktualniony przy użyciu narzędzia do migracji do [[w:pl:Pomoc:Przenośne_infoboksy|przenośnych infoboksów]]',
	'templatedraft-draft-removal-summary' => 'Porządki. Projekt zatwierdzony jako strona nadrzędna.',
	'templatedraft-module-title-create' => 'Migracja infoboksu',
	'templatedraft-module-subtitle-create' => 'Ten szablon nie korzysta z nowych [[w:pl:Pomoc:Przenośne_infoboksy|znaczników infoboksów]].',
	'templatedraft-module-content-create' => 'Możemy wygenerować wersję roboczą znaczników korzystając z istniejącego infoboksu i zapisać ją jako podstronę, żebyś mógł go przejrzeć i wprowadzić niezbędne zmiany.',
	'templatedraft-module-button-create' => 'Wygeneruj wersję roboczą',
	'templatedraft-module-button-title-create' => 'Otwórz nową kartę ze wstępnie wypełnionym formularzem edycji',
	'templatedraft-module-title-approve' => 'Przenieś ten szkic',
	'templatedraft-module-content-approve' => 'Projekt spełnia twoje oczekiwania i chcesz, aby stał się gotowym szablonem?',
	'templatedraft-module-button-approve' => 'Zatwierdź szkic',
	'templatedraft-preview-n-docs' => '== Użycie ==
<pre>
$1</pre>

<br clear="both" />
== Przykład ==
$2<pre>
$2</pre>

[{{fullurl:{{FULLPAGENAME}}|action=purge}} Kliknij tutaj, żeby odświeżyć podgląd].',
	'templatedraft-module-editintro-please-convert' => 'Możemy wygenerować wersję roboczą twojego infoboksu z naszymi nowymi znacznikami. Wystarczy, że klikniesz „$1”.',
	'templatedraft-module-view-parent' => 'kodu głównego szablonu',
	'templatedraft-module-help' => 'stronę pomocy na temat składni infoboksów',
	'templatedraft-invalid-template' => 'Nieprawidłowa nazwa szablonu.',
	'templatedraft-module-approve-protected' => 'Ten szablon jest zabezpieczony. Poproś [[Special:ListAdmins|admina]] o zatwierdzenie szkicu.',
	'templatedraft-protect-edit' => 'Nie masz uprawnień do edytowania strony nadrzędnej.',
	'right-templatedraft' => 'Udostępnia kreator pozwalający na konwersję nieprzenośnych infoboksów na nową składnię',
	'templatedraft-preview-example-value' => 'To jest test',
);

$messages['pt'] = array(
	'templatedraft-description' => 'Extensão TemplateDraft',
	'templatedraft-subpage' => 'Rascunho',
	'templatedraft-editintro' => 'Aqui está! Criamos uma versão preliminar da sua infobox com nossa nova marcação. Nós vamos salvá-la como uma sub-página, para que você possa analisá-la e fazer as alterações necessárias. Você pode querer $1 ou $2.',
	'templatedraft-approval-no-page-error' => 'A aprovação falhou porque a página de rascunho não existe',
	'templatedraft-approval-no-templatedraft-error' => 'A página não é um rascunho de predefinição e portanto não pode ser aprovada.',
	'templatedraft-approval-success-confirmation' => 'O conteúdo desta predefinição foi substituído por uma versão atualizada e o rascunho foi removido',
	'templatedraft-approval-summary' => 'A infobox foi atualizada usando a ferramenta de migração de [[Ajuda:Infoboxes|infoboxes portáteis]]',
	'templatedraft-draft-removal-summary' => 'Limpeza. Rascunho aprovado para a página principal.',
	'templatedraft-module-title-create' => 'Migrar esta infobox',
	'templatedraft-module-subtitle-create' => 'Esta predefinição não utiliza a nova [[Ajuda:Infoboxes|marcação de infobox]].',
	'templatedraft-module-content-create' => 'Nós podemos gerar uma versão preliminar da marcação da sua infobox existente e salvá-la como uma sub-página, para que você possa analisá-la e fazer as alterações necessárias.',
	'templatedraft-module-button-create' => 'Gerar a marcação de rascunho',
	'templatedraft-module-button-title-create' => 'Abrir uma nova aba com um formulário de edição já preenchido',
	'templatedraft-module-title-approve' => 'Mover este rascunho de predefinição',
	'templatedraft-module-content-approve' => 'Você está satisfeito com este rascunho e deseja promovê-lo para uma predefinição ativa?',
	'templatedraft-module-button-approve' => 'Aprovar este rascunho',
	'templatedraft-preview-n-docs' => '== Uso & pré-visualização ==
Digite o seguinte:

<pre>
$1
</pre>

para ver isto:

$2

[{{fullurl:{{ns:Template}}:{{PAGENAME}}}}?action=purge Clique aqui para atualizar a pré-visualização acima]',
	'templatedraft-module-editintro-please-convert' => 'Para gerar uma versão preliminar da sua infobox com nossa nova marcação, basta clicar $1.',
	'templatedraft-module-view-parent' => 'visualizar wikitexto da predefinição principal',
	'templatedraft-module-help' => 'visualizar a página de ajuda sobre marcação de Infobox',
	'templatedraft-invalid-template' => 'Nome inválido de predefinição fornecido.',
	'templatedraft-module-approve-protected' => 'Esta predefinição está protegida. Por favor, pergunte a um  [[Special:ListAdmins|Admin]] para aprovar este projeto.',
	'templatedraft-protect-edit' => 'Você não tem permissão para editar esta página.',
	'right-templatedraft' => 'Permite o acesso a um assistente que ajuda a converter infoboxes de não-portáteis para a nova marcação',
	'templatedraft-preview-example-value' => 'Isto é um teste',
);

$messages['ru'] = array(
	'templatedraft-description' => 'Расширение TemplateDraft',
	'templatedraft-subpage' => 'Модульная версия',
	'templatedraft-editintro' => 'Вы создали модульную версию вашего инфобокса, построенную с использованием новой разметки. Она будет сохранена на подстранице, где вы сможете проверить изменения и внести поправки, если требуется. Вы можете $1 или $2.',
	'templatedraft-approval-no-page-error' => 'Модульной версии данного шаблона не существует',
	'templatedraft-approval-no-templatedraft-error' => 'Эта страница не является модульной версией шаблона',
	'templatedraft-approval-success-confirmation' => 'Содержимое этого шаблона было заменено новой модульной версией из черновика, и черновая версия была удалена',
	'templatedraft-approval-summary' => 'Инфобокс был обновлён с помощью конвертера [[Help:PortableInfoboxes|модульных инфобоксов]]',
	'templatedraft-draft-removal-summary' => 'Модульная версия была одобрена для использования.',
	'templatedraft-module-title-create' => 'Конвертировать этот инфобокс',
	'templatedraft-module-subtitle-create' => 'Этот шаблон не использует новую [[Help:PortableInfoboxes|модульную разметку]] инфобоксов.',
	'templatedraft-module-content-create' => 'Мы можем создать черновую версию новой разметки на основе существующего инфобокса и сохранить её как подстраницу, где вы сможете проверить разметку и внести необходимые изменения.',
	'templatedraft-module-button-create' => 'Создать модульную разметку',
	'templatedraft-module-button-title-create' => 'Открыть новую вкладку с заполненной формой редактирования',
	'templatedraft-module-title-approve' => 'Переместить этот черновик шаблона',
	'templatedraft-module-content-approve' => 'Вы готовы сделать черновую версию шаблона основной?',
	'templatedraft-module-button-approve' => 'Использовать этот черновик',
	'templatedraft-preview-n-docs' => '== Использование ==
Используйте этот код:

<pre>
$1
</pre>

чтобы получить это:

$2

[{{fullurl:{{ns:Template}}:{{PAGENAME}}}}?action=purge Нажмите здесь, чтобы обновить шаблон выше]',
	'templatedraft-module-editintro-please-convert' => 'Мы можем автоматически создать модульную версию вашего инфобокса с помощью новой разметки — просто нажмите $1.',
	'templatedraft-module-view-parent' => 'Просмотр викитекста старой версии шаблона',
	'templatedraft-module-help' => 'Справочная статья о модульных инфобоксах',
	'templatedraft-invalid-template' => 'Недопустимое название шаблона.',
	'templatedraft-module-approve-protected' => 'Этот шаблон был защищён. Пожалуйста, попросите [[Special:ListAdmins|администраторов]] вики одобрить этот черновик.',
	'templatedraft-protect-edit' => 'Вы не имеете разрешения на редактирование родительской страницы.',
	'right-templatedraft' => 'Доступ к инструменту конвертации немодульных инфобоксов с использованием новой разметки',
	'templatedraft-preview-example-value' => 'Тест',
);

$messages['zh-hans'] = array(
	'templatedraft-description' => 'TemplateDraft扩展',
	'templatedraft-subpage' => '模版草稿',
	'templatedraft-editintro' => '好啦！我们已经使用新的标记文件为您生成了讯息框草稿。我们会将其保存为一个子页面，以便于您查看并进行必要的更改。您可以$1或$2。',
	'templatedraft-approval-no-page-error' => '由于页面的草稿不存在，审核操作失败',
	'templatedraft-approval-no-templatedraft-error' => '草稿审核操作不适用于非模版草稿页面',
	'templatedraft-approval-success-confirmation' => '此模版内容已被模版的草稿更新版替换，原模版草稿已被移除',
	'templatedraft-approval-summary' => '使用[[w:c:zh.community:Help:PortableInfoboxes|移动化讯息框]]迁移工具进行更新',
	'templatedraft-draft-removal-summary' => '清理完毕。草稿已被批准为首页面。',
	'templatedraft-module-title-create' => '迁移此讯息框',
	'templatedraft-module-subtitle-create' => '此模版没有使用新的[[w:c:zh.community:Help:移動化訊息框|移动化讯息框]]。',
	'templatedraft-module-content-create' => '我们可以从现用的讯息框生成标记文件的草稿，并保存为子页面，以便于您查看并进行必要的更改。',
	'templatedraft-module-button-create' => '生成标记文件草稿',
	'templatedraft-module-button-title-create' => '打开一个含预填充编辑表单的新选项卡',
	'templatedraft-module-title-approve' => '移动此模版的草稿',
	'templatedraft-module-content-approve' => '对此草案感到满意，并希望将其推广为现用模版？',
	'templatedraft-module-button-approve' => '批准此模版草稿',
	'templatedraft-preview-n-docs' => '== 使用与预览==
键入下列信息：

<pre>
$1
</pre>

以看到下列信息：

$2

[{{fullurl:{{ns:Template}}:{{PAGENAME}}}}?action=purge 点击此处刷新上面的预览内容]',
	'templatedraft-module-editintro-please-convert' => '我们可以用我们的新标记文件为您生成讯息框草稿，只需点击$1即可。',
	'templatedraft-module-view-parent' => '查看主模版的wikitext',
	'templatedraft-module-help' => '查看讯息框标记文件的帮助页面',
	'templatedraft-invalid-template' => '提供的模版名称无效',
	'templatedraft-module-approve-protected' => '此模板受到保护。请询问[[Special:ListAdmins|管理员]]批准这一草稿。',
	'templatedraft-protect-edit' => '您没有权限编辑首页面。',
	'right-templatedraft' => '允许向导帮助非移动式讯息框转换成一个新的标记文件',
	'templatedraft-preview-example-value' => '这是一个测试',
);

$messages['zh-hant'] = array(
	'templatedraft-description' => '模板草稿的擴展功能',
	'templatedraft-subpage' => '模版草稿',
	'templatedraft-editintro' => '好啦！ 我們已經使用新的標記方式為您製作了訊息框草稿。 我們會將其保存為一個子頁面，以便於您查看並進行必要的更改。 您可以$1或$2。',
	'templatedraft-approval-no-page-error' => '審核操作失敗，因為草稿頁面不存在。',
	'templatedraft-approval-no-templatedraft-error' => '草稿審核操作不適用於非模板草稿頁面',
	'templatedraft-approval-success-confirmation' => '模板内容已經由模板草稿更新替換，模板草稿已經被移除',
	'templatedraft-approval-summary' => '使用[[w:c:zh.community:Help:移動化訊息框|行動化訊息框]]遷移工具進行更新',
	'templatedraft-draft-removal-summary' => '清理完畢。 草稿已批准而成為主頁面。',
	'templatedraft-module-title-create' => '變更這個訊息框',
	'templatedraft-module-subtitle-create' => '這個模板沒有使用新的[[w:c:zh.community:Help:移動化訊息框|行動化訊息框]]。',
	'templatedraft-module-content-create' => '我們可以從現在用的訊息框生成標記文件的草稿，並保存為子頁面，以便於你查看並進行必要的更改。',
	'templatedraft-module-button-create' => '生成標記文件草稿',
	'templatedraft-module-button-title-create' => '開啟一個有預填充編輯表單的新標籤',
	'templatedraft-module-title-approve' => '移動這個模板草稿',
	'templatedraft-module-content-approve' => '對這個草稿感到滿意，並希望讓它生效成為主模板？',
	'templatedraft-module-button-approve' => '批准這個模板的草稿',
	'templatedraft-preview-n-docs' => '== 使用與預覽 ==
鍵入下面的資訊：

<pre>
$1
</pre>

可以看到下面的資訊：

$2

[{{fullurl:{{ns:Template}}:{{PAGENAME}}}}?action=purge 按一下這裡刷新上面的預覽内容]',
	'templatedraft-module-editintro-please-convert' => '我們可以用我們的新標記文件為你生成資訊框的草稿，只需按一下$1就可以了。',
	'templatedraft-module-view-parent' => '查看主模板的wiki文本',
	'templatedraft-module-help' => '查看資訊框標記文件的幫助頁面',
	'templatedraft-invalid-template' => '提供的模版名稱無效',
	'templatedraft-module-approve-protected' => '此模板受到保護。 請諮詢[[Special:ListAdmins|管理員]]批准這個草稿。',
	'templatedraft-protect-edit' => '您沒有權限編輯主頁面。',
	'right-templatedraft' => '允許使用將非行動訊息框轉變為新標記方式的協助精靈',
	'templatedraft-preview-example-value' => '這是一個測試',
);

