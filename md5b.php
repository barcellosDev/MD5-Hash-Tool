<?php 
/**
 * Code that brutes md5 hashes by Alan Barcellos
 */
error_reporting(0);
abstract class md5Brute
{
	private static $rotas = [
		'file' => ['--file' => '-f'],
		'verbose' => ['--verbose' => '-v']
	];

	private static function verifyArgs()
	{
		global $argv;

		foreach ($argv as $key => $value) 
		{
			foreach (self::$rotas['file'] as $k => $v) 
			{
				if ($k == $value or $v == $value) 
				{
					$txt = explode('.', $argv[$key+1]);
					$file = (isset($argv[$key+1]) and count($txt) == 2 and !empty($txt[1])) ? $argv[$key+1] : null;
				}
			}
			foreach (self::$rotas['verbose'] as $k2 => $v2) 
			{
				if ($k2 == $value or $v2 == $value) 
				{
					$verbose = $value;
				}
			}
			$hash = end($argv);
		}
		if (is_null($file)) 
		{
			echo "Defina um arquivo .TXT válido!";
		} else 
		{
			if (isset($verbose)) 
			{
				return ['ARQUIVO' => $file, 'VERBOSE' => $verbose, 'HASH' => $hash];
			} else 
			{
				return ['ARQUIVO' => $file, 'HASH' => $hash];
			}
		}
	}

	private static function Ajuda()
	{
		echo "
		Utilize --file ou -f para definir a wordlist
		Utilize --verbose ou -v se quiser mais detalhes no momento da realização do bruteforce\n
		";
	}

	public static function Brute()
	{
		global $argv;
		if (count($argv) == 1) 
		{
			self::Ajuda();
			echo "[>] Você deseja criar uma nova hash md5? Digite yes ou qualquer coisa para finalizar o script: ";
			$option = trim(fgets(STDIN));
			if ($option == 'yes')
			{
				echo "[>] Por favor insira sua string para hash\n => ";
				$option2 = trim(fgets(STDIN));
				if (is_string($option2)) 
				{
					echo "[+] String 'hasheada' com sucesso! [>] ".md5($option2)." [<]";
				} else 
				{
					echo "\nPor favor insira uma string válida!\n";
				}
			} else 
			{
				echo "\nBye bye!\n";
			}
		} else 
		{
			$comandos = self::verifyArgs();

			$words = file($comandos['ARQUIVO'], FILE_TEXT | FILE_IGNORE_NEW_LINES);
			$hashes = [];
			foreach ($words as $k => $v) 
			{
				$hashes[$v] = md5($v);
			}

			if (!isset($comandos['VERBOSE'])) 
			{
				if (is_file($comandos['HASH'])) 
				{
					$f_hashes = file($comandos['HASH'], FILE_TEXT | FILE_IGNORE_NEW_LINES);
					foreach ($hashes as $w => $h) 
					{
						foreach ($f_hashes as $KH => $VH)
						{
							if ($h == $VH) 
							{
								$hashes_finais[] = $w;
							}
						}
					}
					if (!is_array($hashes_finais)) 
					{
						echo "[-] As hashes não foram encontradas!";
					} else 
					{
						echo "[>] Você quer salvar os resultados em um arquivo? (Y n): ";
						$c1 = trim(fgets(STDIN));
						if ($c1 != 'n')
						{
							file_put_contents('resultados.txt', implode("\n", $hashes_finais), FILE_TEXT);
						} else 
						{
							foreach ($hashes_finais as $i => $fh)
							{
								echo "[+] STRING ENCONTRADA: ".$fh."\n";
							}
						}
					}
				} else
				{
					foreach ($hashes as $w => $h) 
					{
						if ($comandos['HASH'] == $h) 
						{
							$hash_final = $w;
						}
					}
					if (!is_string($hash_final)) 
					{
						echo "[-] A hash não foi encontrada!";
					} else 
					{
						echo '
						* A hash foi quebrada
						* HASH: '.$comandos['HASH'].'
						* STRING DECIFRADA: '.$hash_final.'
						';
					}
				}
			} else 
			{
				if (is_file($comandos['HASH'])) 
				{
					$f_hashes = file($comandos['HASH'], FILE_TEXT | FILE_IGNORE_NEW_LINES);
					foreach ($hashes as $w => $h) 
					{
						foreach ($f_hashes as $kw => $vh) 
						{
							if ($vh != $h) 
							{
								echo "[-] Palavra (".$w.") inválida\n";
							} else 
							{
								$hashes_finais[] = $w;
							}
						}
					}
					echo "\n";
					foreach ($hashes_finais as $i => $fh) 
					{						
						echo "[+] STRINGS ENCONTRADAS: ".$fh."\n";
					}
					echo "[!] Você quer salvar os resultados em um arquivo? (Y or n): ";
					$c1 = trim(fgets(STDIN));
					if ($c1 != 'n') 
					{
						file_put_contents('resultados.txt', implode("\n", $hashes_finais), FILE_TEXT);
					}
					exit();
				}
				foreach ($hashes as $w => $h) 
				{
					if ($comandos['HASH'] != $h) 
					{
						echo "[-] Hash [".$h."] da palavra [".$w."] inválida \n";
					} else 
					{
						$hash_final = $w;
					}
				}
				if (is_string($hash_final))
				{
					echo '
					[+] A hash foi quebrada
					[+] HASH: '.$comandos['HASH'].'
					[+] STRING DECIFRADA: '.$hash_final.'
					';
				}
			}
		}
	}
}
md5Brute::Brute();
?>