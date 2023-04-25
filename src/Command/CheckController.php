<?php

namespace Wirelab\Command;

use App\CommandController;
use App\Hash;

final class CheckController extends CommandController
{
    public function run(array $argv = []): void
    {
        $this->printer()->info("Checking hash");
        $this->printer()->info("-------------");

        if(Hash::check('integrity.zip')) {
            $this->printer()->info("Integrity check passed");
            exit(0);
        } 
        $this->printer()->info("Integrity check failed");
        exit(1);
    }

    // private function shaFile($file)
    // {
    //     $filePath = getcwd() . "/$file";
    //     return sha1_file($filePath);
    // }

    // private function result(array $valid = [], array $invalid = [])
    // {
    //     return [
    //         'valid' => $valid,
    //         'invalid' => $invalid
    //     ];
    // }

    // private function exclude()
    // {
    //     return [
    //         '.',
    //         '..',
    //         '.idea',
    //         'node_modules',
    //     ];
    // }

    // private function knownHashes()
    // {
    //     return [
    //         "README.md" => '84437ba57ed919445f17d86dc9447ab7c73a7864',
    //         "composer.json" => 'a79fd33dbe61db1dbf9330b152055fe2b3717619',
    //         "integrity" => '604baa2846791f3e778c807d75edd9a4788722a3',
    //     ];
    // }

    // private function fakeHashes()
    // {
    //     return [
    //         "README.md" => '74437ba57ed919445f17d86dc9447ab7c73a7864',
    //         "composer.json" => 'a79fd33dbe61db1dbf9330b152055fe2b3717619',
    //         "integrity" => '604baa2846791f3e778c807d75edd9a4788722a3',
    //     ];
    // }

    // private function check(array $hashes, $file)
    // {
    //     return $hashes[$file] === $this->shaFile($file);
    // }
}