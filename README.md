# MD5 Simple Crypter/Decrypter

**Tool created to performs simple crypt and decrypt md5 hashes or md5 hashes inside a txt file**

**Usage:**

<table>
	<tr>
		<th>Comando</th>
		<th>Opções</th>
		<th>Definição</th>
	</tr>
	<tr>
		<td rowspan="3">php md5b.php</td>
		<td>--file ou -f</td>
		<td>Define a wordlist a ser usada para tentativa de quebra da hash informada</td>
	</tr>
	<tr>
		<td>--verbose ou -v</td>
		<td>Define se se irá ver qual hash está sendo quebrada</td>
	</tr>
	<tr>
		<td>(Insira a hash depois do último argumento)</td>
		<td>Após todos os argumentos, insira a hash ou um arquivo de hashes MD5 a ser quebrada</td>
	</tr>
</table>

__Ex:__
_php md5b.php --file worldlist.txt --verbose 698dc19d489c4e4db73e28a713eab07b_

**Se nada informado, o script pergunta se você deseja hashear uma string**

_php md5b.php -f senhaslist.txt hashes.txt_