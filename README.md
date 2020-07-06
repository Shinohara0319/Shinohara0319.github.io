claspのpullとpushを触って挙動見てみた。
pushの挙動。
ログインする。(PATH="/usr/local/bin:$PATH" npx @google/clasp login )省略可能かは未実施。
ローカルにcloneしてきたコードを変更後、push。(PATH="/usr/local/bin:$PATH" npx @google/clasp push scriptId)
この時点で、ブラウザで該当のscriptファイルを開いてると反映されない。
一度ブラウザで該当のscriptファイルだけを閉じて(ブラウザごと閉じる必要はない)、再度開きなおすと反映されてる。
pullの挙動。
pushと同じ。
ブラウザ上でコードを更新して、ローカルと差異を作る。
差異がある状態で、ローカルでpullする。(`PATH="/usr/local/bin:$PATH" npx @google/clasp pull scriptId`)
ローカルに反映される。(たまに反映されない事もあるぽいけど、pushと同じ感じでローカルの該当scriptファイルを閉じてから開きなおすと反映される。)
尚、以下のように同じファイルの同じ行に以下のようにコードを追加してると、コンフリクトは起きずにweb上のコードに上書きされてローカルに書いた内容は消える。つまりコンフリクトってのは存在しなそう。(githubのmasterにmergeしてからpush/pullしてる分には起こりえないと思うけど)
