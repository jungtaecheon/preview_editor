<!DOCTYPE html>
<html lang="ja">
	<head>
		<meta charset="UTF-8">

		<!-- Official https://codemirror.net/doc/manual.html -->
		<title>ライブプレビューエディター</title>

		<link rel="stylesheet" href="codemirror-5.52.0/lib/codemirror.css">

		<link rel="stylesheet" href="codemirror-5.52.0/addon/hint/show-hint.css">

		<link rel="stylesheet" href="codemirror-5.52.0/addon/dialog/dialog.css">

		<link rel="stylesheet" href="codemirror-5.52.0/theme/material-darker.css">
		<link rel="stylesheet" href="codemirror-5.52.0/theme/material.css">

		<script src="codemirror-5.52.0/lib/codemirror.js"></script>

		<script src="codemirror-5.52.0/mode/javascript/javascript.js"></script>
		<script src="codemirror-5.52.0/mode/htmlmixed/htmlmixed.js"></script>
		<script src="codemirror-5.52.0/mode/xml/xml.js"></script>
		<script src="codemirror-5.52.0/mode/css/css.js"></script>

		<script src="codemirror-5.52.0/addon/display/placeholder.js"></script>

		<script src="codemirror-5.52.0/addon/fold/xml-fold.js"></script>

		<script src="codemirror-5.52.0/addon/dialog/dialog.js"></script>

		<script src="codemirror-5.52.0/addon/selection/active-line.js"></script>

		<script src="codemirror-5.52.0/addon/search/search.js"></script>
		<script src="codemirror-5.52.0/addon/search/searchcursor.js"></script>
		<script src="codemirror-5.52.0/addon/search/jump-to-line.js"></script>

		<script src="codemirror-5.52.0/addon/edit/closebrackets.js"></script>
		<script src="codemirror-5.52.0/addon/edit/closetag.js"></script>
		<script src="codemirror-5.52.0/addon/edit/matchbrackets.js"></script>
		<script src="codemirror-5.52.0/addon/edit/matchtags.js"></script>
		<script src="codemirror-5.52.0/addon/edit/trailingspace.js"></script>

		<script src="codemirror-5.52.0/addon/hint/show-hint.js"></script>
		<script src="codemirror-5.52.0/addon/hint/anyword-hint.js"></script>
		<script src="codemirror-5.52.0/addon/hint/sql-hint.js"></script>
		<script src="codemirror-5.52.0/addon/hint/xml-hint.js"></script>
		<script src="codemirror-5.52.0/addon/hint/html-hint.js"></script>
		<script src="codemirror-5.52.0/addon/hint/css-hint.js"></script>
		<script src="codemirror-5.52.0/addon/hint/javascript-hint.js"></script>

		<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.0.0/jquery.slim.min.js"></script>

		<style type="text/css">
			/** タイトルのおしゃれ括弧 */
			.headDescription {
				font-size: 100%;
				position: relative;
				padding: 0.25em 1em;
				border-top: solid 2px black;
				border-bottom: solid 2px black;
			}

			.headDescription:before,
			.headDescription:after {
				content: '';
				position: absolute;
				top: -7px;
				width: 2px;
				height: -webkit-calc(100% + 14px);
				height: calc(100% + 14px);
				background-color: black;
			}

			.headDescription:before {
				left: 7px;
			}

			.headDescription:after {
				right: 7px;
			}

			/** ボタン */
			.btn-square-above-look {
				display: inline-block;
				position: relative;
				padding: 0.35em 1em;
				background: #668ad8;
				/*ボタン色*/
				color: #FFF;
				text-decoration: none;
			}

			.btn-square-above-look:before {
				content: "";
				position: absolute;
				top: -16px;
				left: 0;
				width: -webkit-calc(100% - 16px);
				width: calc(100% - 16px);
				height: 0;
				border: solid 8px transparent;
				border-bottom-color: #8eacec;
				/*ボタン色より明るめの色に*/
			}

			.btn-square-above-look:active {
				/*押したとき*/
				padding: 0.32em 0.9em;
				-webkit-transform: translateY(-2px);
				transform: translateY(-2px);
			}

			.btn-square-above-look:active:before {
				width: -webkit-calc(100% - 12px);
				width: calc(100% - 12px);
			}

			.btn-square-above-look:active:before {
				top: -12px;
				border-width: 6px;
			}

			/** コードミラーの上書き */
			.CodeMirror {
				font-family: Monaco, 'Andale Mono', 'Lucida Console', 'Bitstream Vera Sans Mono', 'Courier New', Courier, monospace;
				font-size: 10pt;
				height: 100%;
			}

			/** 無駄space */
			.cm-trailingspace {
				background-image: url(data:image/png;base64,iVBORw0KGgoAAAANSUhEUgAAAAQAAAACCAYAAAB/qH1jAAAABmJLR0QA/wD/AP+gvaeTAAAACXBIWXMAAAsTAAALEwEAmpwYAAAAB3RJTUUH3QUXCToH00Y1UgAAACFJREFUCNdjPMDBUc/AwNDAAAFMTAwMDA0OP34wQgX/AQBYgwYEx4f9lQAAAABJRU5ErkJggg==);
			}

			/** placeholder */
			.CodeMirror-empty {
				outline: 1px solid #c22;
			}

			.CodeMirror-empty.CodeMirror-focused {
				outline: none;
			}

			.CodeMirror pre.CodeMirror-placeholder {
				color: #999;
			}

			.help {
				font-size: 85%;
				background: #EEEEEE;
				z-index: 100;
				position: fixed;
				top: 50%;
				left: 50%;
				transform: translate(-50%, -50%);
				width: 45%;
			}

			.sample_code {
				background: #EEEEEE;
			}

			.editor{
				float: left;
				width: 49%;
			}
			.preview{
				z-index: -1;
				position: fixed;
				bottom: 10%;
				right: 5%;
				transform: translate(5%, 10%);
				width: 45%;
			}

		</style>
	</head>

	<body>
		<div class="helpButton">
			<input id="open_and_close_help" class="btn-square-above-look" type="button" value="ヘルプを開く" onclick="hideAndShow()" />
			<input id="open_and_close_sample_code" class="btn-square-above-look" type="button" value="サンプルコードを開く" onclick="hideAndShowSampleCode()" />
		</div>

		<div align="center">
			<h1>分割編集モード</h1>
			<a style="color:red;" href="./preview_editor_full.php">
				<h3>まとめ編集モードはこちら</h3>
			</a>
		</div>

		<div id="help" class="help">
			<input style="float: right;" type="button" value="X" onclick="hideAndShow()" />
			<br>

			<h1 class="headDescription">ヘルプ</h1>

			<hr>

			<b>- 自動補完機能</b><br>
			「Ctrl or Command」 + 「スペースキー」 を押すと、自動補完機能を使えます。<br>

			<hr>

			<b>- 自動インデント機能</b><br>
			「Shift」 + 「Tab」 を押すと、選択された部分のインデントが自動で修正されます。<br>
			「Ctrl or Command」 + 「A」 を押すと、全体選択できるので全体のインデントを修正するときに使ってみよう。<br>

			<hr>

			<b>- タグのジャンプ機能</b><br>
			片方のタグにカーソルをあてたあと<br>
			「Ctrl or Command」 + 「J」 を押すと、もう片方のタグにジャンプします。

			<hr>

			<b>- ハイライト検索機能</b><br>
			「Ctrl or Command」 + 「F」 を押すと、指定のキーワードにハイライトをつけることができます。<br>
			「Ctrl or Command」 + 「G」 を押すと、ハイライトされたキーワードを順に検索することができます。
		</div>

		<div class="editor">
			<h1 class="headDescription">HTML</h1>
			<div class="sample_code">
				サンプルコード
				<input type="button" value="コピー" onclick="copyTextArea('sample_code_1')" class="btn-square-above-look">
				<textarea id="sample_code_1" rows="15" cols="50" readonly><?php include("./sample_code/table_body.html");?></textarea>
			</div>

			<hr>

			<textarea id="editor_html" class="CodeMirror-empty" placeholder="<body>タグの中身を作成してください。" rows="30" cols="50"></textarea>

			<h1 class="headDescription">css</h1>
			<div class="sample_code">
				サンプルコード
				<input type="button" value="コピー" onclick="copyTextArea('sample_code_2')" class="btn-square-above-look">
				<textarea id="sample_code_2" rows="15" cols="50" readonly><?php include("./sample_code/table_style_sheet.css");?></textarea>
			</div>

			<hr>

			<textarea id="editor_css" class="CodeMirror-empty" placeholder="スタイルシート(css)の中身を生成してください。" rows="30" cols="50"></textarea>

			<h1 class="headDescription">javascript</h1>
				<div class="sample_code">
				サンプルコード
				<input type="button" value="コピー" onclick="copyTextArea('sample_code_3')" class="btn-square-above-look">
				<textarea id="sample_code_3" rows="15" cols="50" readonly><?php include("./sample_code/table_javascript.js");?></textarea>
			</div>

			<hr>

			<textarea id="editor_js" class="CodeMirror-empty" placeholder="<script>タグの中身を作成してください。" rows="30" cols="50"></textarea>
		</div>

		<div class="preview">
			<h1 class="headDescription">プレビュー</h1>
			<input id="title_html" type="text" placeholder="保存するファイル名（タイトル）を入力してください" size="60">
			<input class="btn-square-above-look" type="button" value="ソースコードをダウンロード" onclick="downloadfile()">
			<div id="livepreview">
				<iframe id="livepreview_frame" width="100%" height="300px"></iframe>
			</div>
		</div>

		<script>
			const INDENT_SIZE = 4;
			const INDENT_SPACE = "\t";

			var htmlEitor = CodeMirror.fromTextArea(document.getElementById('editor_html'), {
				mode: 'htmlmixed',
				lineNumbers: true,
				autofocus: true,
				lineWrapping: false,
				readOnly: false,
				firstLineNumber: 1,
				indentUnit: INDENT_SIZE,
				tabSize: INDENT_SIZE,
				indentWithTabs: true, // インデントの際、tabSize x N 個分のスペースが続いたら、それを N 個のタブに置き換えるかどうか。（デフォルト：false）
				autoCloseBrackets: true,
				autoCloseTags: true,
				matchBrackets: true,
				showTrailingSpace: true,
				styleActiveLine: true,
				matchTags: {
					bothTags: true
				},
				extraKeys: {
					"Ctrl-Space": "autocomplete",
					"Cmd-Space": "autocomplete",
					"Ctrl-J": "toMatchingTag",
					"Cmd-J": "toMatchingTag",
				},
				theme: 'material'
			});
			htmlEitor.setSize("100%", "300px");

			var jsEitor = CodeMirror.fromTextArea(document.getElementById('editor_js'), {
				mode: 'javascript',
				lineNumbers: true,
				autofocus: false,
				lineWrapping: false,
				readOnly: false,
				firstLineNumber: 1,
				indentUnit: INDENT_SIZE,
				tabSize: INDENT_SIZE,
				indentWithTabs: true, // インデントの際、tabSize x N 個分のスペースが続いたら、それを N 個のタブに置き換えるかどうか。（デフォルト：false）
				autoCloseBrackets: true,
				autoCloseTags: true,
				matchBrackets: true,
				showTrailingSpace: true,
				styleActiveLine: true,
				matchTags: {
					bothTags: true
				},
				extraKeys: {
					"Ctrl-Space": "autocomplete",
					"Cmd-Space": "autocomplete",
					"Ctrl-J": "toMatchingTag",
					"Cmd-J": "toMatchingTag",
				},
				theme: 'material'
			});
			jsEitor.setSize("100%", "300px");

			var cssEitor = CodeMirror.fromTextArea(document.getElementById('editor_css'), {
				mode: 'text/css',
				lineNumbers: true,
				autofocus: false,
				lineWrapping: false,
				readOnly: false,
				firstLineNumber: 1,
				indentUnit: INDENT_SIZE,
				tabSize: INDENT_SIZE,
				indentWithTabs: true, // インデントの際、tabSize x N 個分のスペースが続いたら、それを N 個のタブに置き換えるかどうか。（デフォルト：false）
				autoCloseBrackets: true,
				autoCloseTags: true,
				matchBrackets: true,
				showTrailingSpace: true,
				styleActiveLine: true,
				matchTags: {
					bothTags: true
				},
				extraKeys: {
					"Ctrl-Space": "autocomplete",
					"Cmd-Space": "autocomplete",
					"Ctrl-J": "toMatchingTag",
					"Cmd-J": "toMatchingTag",
				},
				theme: 'material'
			});
			cssEitor.setSize("100%", "300px");


			var sampleCode1 = CodeMirror.fromTextArea(document.getElementById('sample_code_1'), {
				mode: 'htmlmixed',
				lineNumbers: true,
				lineWrapping: false,
				readOnly: true,
				matchBrackets: true,
				showTrailingSpace: true,
				styleActiveLine: true,
				matchTags: {
					bothTags: true
				},
				extraKeys: {
					"Ctrl-J": "toMatchingTag",
					"Cmd-J": "toMatchingTag",
				},
				theme: 'material'
			});
			sampleCode1.setSize("100%", "80px");

			var sampleCode2 = CodeMirror.fromTextArea(document.getElementById('sample_code_2'), {
				mode: 'text/css',
				lineNumbers: true,
				lineWrapping: false,
				readOnly: true,
				matchBrackets: true,
				showTrailingSpace: true,
				styleActiveLine: true,
				matchTags: {
					bothTags: true
				},
				extraKeys: {
					"Ctrl-J": "toMatchingTag",
					"Cmd-J": "toMatchingTag",
				},
				theme: 'material'
			});
			sampleCode2.setSize("100%", "80px");

			var sampleCode3 = CodeMirror.fromTextArea(document.getElementById('sample_code_3'), {
				mode: 'javascript',
				lineNumbers: true,
				lineWrapping: false,
				readOnly: true,
				matchBrackets: true,
				showTrailingSpace: true,
				styleActiveLine: true,
				matchTags: {
					bothTags: true
				},
				extraKeys: {
					"Ctrl-J": "toMatchingTag",
					"Cmd-J": "toMatchingTag",
				},
				theme: 'material'
			});
			sampleCode3.setSize("100%", "80px");

			$(function() {
			// JQuery
				$('.editor').keyup(function(e) {
					// textAreaに同期
					updateTextArea();
					// textAreaからプレビュー生成
					var blob = createHtmlBlob();
					var iframe = document.getElementById('livepreview_frame');
					iframe.src = URL.createObjectURL(blob);
				});

				$('.preview').keyup(function(e) {
					// textAreaに同期
					updateTextArea();
					// textAreaからプレビュー生成
					var blob = createHtmlBlob();
					var iframe = document.getElementById('livepreview_frame');
					iframe.src = URL.createObjectURL(blob);
				});
			});

			function updateTextArea(){
				// エディターの中身をtextAreaに同期させる。
				htmlEitor.save();
				jsEitor.save();
				cssEitor.save();
			}

			function getSpaceByHierarchy(level){
				var space = "";
				for(var i=0; i<level; i++){
					space += INDENT_SPACE;
				}
				return space;
			}

			function createHtmlBlob(){
				//各フォームの値を取得
				var title = document.getElementById("title_html").value;
				var htmlbody = document.getElementById("editor_html").value;
				var javascript = document.getElementById("editor_js").value;
				var css = document.getElementById("editor_css").value;

				// すべての行に指定された階層のインデントを入れる
				htmlbody = htmlbody.replace(/(^.*)/mg, getSpaceByHierarchy(2)+"$1");
				javascript = javascript.replace(/(^.*)/mg, getSpaceByHierarchy(3)+"$1");
				css = css.replace(/(^.*)/mg, getSpaceByHierarchy(3)+"$1");

				// htmlの内容を変数に格納
				var html =
				'<!DOCTYPE html>\n' +
				'<html lang="ja">\n' +
				getSpaceByHierarchy(1) + '<head>\n' +
				getSpaceByHierarchy(2) + '<meta charset="UTF-8">\n' +
				getSpaceByHierarchy(2) +'<title>' + title + '</title>\n' +
				getSpaceByHierarchy(2) +'<style type="text/css">\n' +
				css + "\n" +
				getSpaceByHierarchy(2) +'</style>\n' +
				getSpaceByHierarchy(2) +'<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.0.0/jquery.slim.min.js"><\/script>\n' +
				getSpaceByHierarchy(1) +'</head>\n\n' +
				getSpaceByHierarchy(1) +'<body>\n' +
				htmlbody + "\n\n" +
				getSpaceByHierarchy(2) +'<script>\n' +
				javascript + "\n" +
				getSpaceByHierarchy(2) +'<\/script>\n' +
				getSpaceByHierarchy(1) +'</body>\n' +
				'</html>';

				// 改行などによる余分なスペースを削除
				html = html.replace(/^(\s)+$/mg, "");

				//blobとしてhtmlファイルを生成
				var blob = new Blob([html],{type: "text/html;"});

				return blob;
			}

			function downloadfile(){
				if(!confirm("作成したHTMLファイルをローカルにダウンロードしますか？")) return;
				var title = document.getElementById("title_html").value;
				var blob = createHtmlBlob();

				//a要素を作成してクリックイベント実行
				var a = document.createElement("a");
				a.href = URL.createObjectURL(blob);
				a.target = '_blank';
				a.download = title + '.html';
				a.click();
			}

			document.getElementById("help").style.display = "none";
			function hideAndShow() {
				const help = document.getElementById("help");
				if (help.style.display == "block") {
					document.getElementById("open_and_close_help").value = "ヘルプを開く";
					help.style.display = "none";
				} else {
					document.getElementById("open_and_close_help").value = "ヘルプを閉じる";
					help.style.display = "block";
				}
			}


			const sample_code_class = document.getElementsByClassName("sample_code");
			for(var i = 0; i < sample_code_class.length; i++){
				sample_code_class[i].style.display = "none";
			}
			function hideAndShowSampleCode() {
				const sample_code_class = document.getElementsByClassName("sample_code");
				if (sample_code_class[0].style.display == "block") {
					document.getElementById("open_and_close_sample_code").value = "サンプルコードを開く";
					for(var i = 0; i < sample_code_class.length; i++){
						sample_code_class[i].style.display = "none";
					}

				} else {
					document.getElementById("open_and_close_sample_code").value = "サンプルコードを閉じる";
					for(var i = 0; i < sample_code_class.length; i++){
						sample_code_class[i].style.display = "block";
					}
				}
			}

			function copyTextArea(targetId){
				var targetTextArea = document.getElementById(targetId);
				targetTextArea.style.display = "block";
				targetTextArea.select();
				document.execCommand("copy");
				targetTextArea.style.display = "none";
				alert("コピーしました！\nこのまま貼り付けができます。");
			}
		</script>

	</body>
</html>