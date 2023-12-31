<?php

declare(strict_types=1);

namespace App\Service\Filter;

use App\DTO\PokeAPI\Pokemon;
use App\Enum\PokemonTypeEnum;
use App\Service\GetTypePokemon;

class Filter
{
    /**
     * @param Pokemon $pokemon
     * @param PokemonTypeEnum|null $type
     * @return Pokemon|null $pokemon
     */
    public function filterPokemon(Pokemon $pokemon, ?PokemonTypeEnum $type): ?Pokemon
    {
        // $typeが存在する場合は、$pokemonのタイプと一致するか確認する
        if (!is_null($type)) {
            // $pokemonのタイプを取得する
            $getTypePokemon = new GetTypePokemon();
            $pokemonTypes = $getTypePokemon->getTypeName($pokemon->getTypes());
            // $typeと一致するタイプが存在するか確認する
            $isMatch = false;
            foreach ($pokemonTypes as $pokemonType) {
                if ($pokemonType->getType()->getName() === $type->value) {
                    $isMatch = true;
                    break;
                }
            }
            // 一致しない場合は、nullにして返す
            if (!$isMatch) {
                return null;
            }
        }

        return $pokemon;
    }
}
