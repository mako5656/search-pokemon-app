<?php

declare(strict_types=1);

namespace App\Service;

use App\Repository\ListInfoPokemon;

class AddLimitPokemon
{
    public function __construct(
        private readonly PokeAPI $pokeApi,
        private readonly GetImagePokemon $getImagePokemon,
        private readonly GetTypePokemon $getTypePokemon,
        private readonly Filter $filter,
    ) {
    }

    public function addLimitPokemon(ListInfoPokemon $listInfoPokemon, array $data, int $max, int $i): ListInfoPokemon
    {
        $pokemon = $this->pokeApi->fetchPokemonId($max + $i);
        $pokemon = $this->filter->filterPokemon($pokemon, $data['name'], $data['type']);

        if (!is_null($pokemon)) {
            $listInfoPokemon
                ->addId($pokemon->getId())
                ->addName($pokemon->getName())
                ->addImage($this->getImagePokemon->getImageUrl($pokemon->getSprites(), $data['image']))
                ->addTypeColor($this->getTypePokemon->getTypeColor($pokemon->getTypes()))
            ;
        }

        return $listInfoPokemon;
    }
}
