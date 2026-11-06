<?php

namespace App\Utils;

class YapitaBusinessSchemaTypeUtil
{
    /**
     * Mapeo completo de las 76 subcategorías
     * registradas en Yapita.
     *
     * Los tipos genéricos se pueden personalizar
     * posteriormente según cada establecimiento.
     */
    private const SUBCATEGORY_TYPES = [

        // ======================================
        // 1. COMIDA Y BEBIDA
        // ======================================
        1  => 'Restaurant',
        2  => 'CafeOrCoffeeShop',
        3  => 'IceCreamShop',
        4  => 'Bakery',
        5  => 'BarOrPub',
        6  => 'Restaurant',
        7  => 'Restaurant',
        8  => 'Restaurant',
        9  => 'Restaurant',
        10 => 'Restaurant',
        11 => 'Restaurant',
        12 => 'Restaurant',
        13 => 'Restaurant',
        14 => 'FastFoodRestaurant',
        15 => 'Restaurant',
        16 => 'FoodEstablishment',

        // ======================================
        // 2. OCIO
        // ======================================
        17 => 'LocalBusiness',
        18 => 'ExerciseGym',
        19 => 'ArtGallery',
        20 => 'EntertainmentBusiness',
        21 => 'EntertainmentBusiness',
        22 => 'MovieTheater',
        23 => 'Museum',
        24 => 'LocalBusiness',
        25 => 'Library',
        26 => 'EntertainmentBusiness',

        // ======================================
        // 3. COMERCIOS
        // ======================================
        27 => 'Store',
        28 => 'BeautySalon',
        29 => 'Store',
        30 => 'OfficeEquipmentStore',
        31 => 'GroceryStore',
        32 => 'ElectronicsStore',
        33 => 'FurnitureStore',
        34 => 'GroceryStore',
        35 => 'BikeStore',
        36 => 'AutomotiveBusiness',
        37 => 'ShoeStore',
        38 => 'GardenStore',
        39 => 'Store',

        // ======================================
        // 4. OFICIOS Y SERVICIOS
        // ======================================
        40 => 'ProfessionalService',
        41 => 'LodgingBusiness',
        42 => 'FinancialService',
        43 => 'ProfessionalService',
        44 => 'ProfessionalService',
        45 => 'LocalBusiness',
        46 => 'LocalBusiness',
        47 => 'ProfessionalService',

        // ======================================
        // 5. SALUD
        // ======================================
        48 => 'Hospital',
        49 => 'MedicalBusiness',
        50 => 'MedicalClinic',
        51 => 'MedicalClinic',
        52 => 'VeterinaryCare',
        53 => 'MedicalBusiness',

        // ======================================
        // 6. CONSTRUCCIÓN
        // ======================================
        54 => 'HardwareStore',
        55 => 'Store',
        56 => 'LocalBusiness',
        57 => 'GeneralContractor',
        58 => 'HomeAndConstructionBusiness',

        // ======================================
        // 7. TEXTIL
        // ======================================
        59 => 'LocalBusiness',
        60 => 'ClothingStore',
        61 => 'Store',
        62 => 'ClothingStore',
        63 => 'LocalBusiness',
        64 => 'ClothingStore',
        65 => 'Store',

        // ======================================
        // 8. TRANSPORTE
        // ======================================
        66 => 'LocalBusiness',
        67 => 'LocalBusiness',
        68 => 'LocalBusiness',
        69 => 'LocalBusiness',

        // ======================================
        // EDUCACIÓN
        // ======================================
        70 => 'LocalBusiness',
        71 => 'LocalBusiness',
        72 => 'ChildCare',
        73 => 'ChildCare',
        74 => 'LocalBusiness',
        75 => 'LocalBusiness',

        // ======================================
        // TURISMO
        // ======================================
        76 => 'LocalBusiness',
    ];

    /**
     * Obtener tipo Schema.org.
     */
    public static function resolve(
        ?int $subcategoryId,
        ?string $override = null
    ): string {

        // Permitir una clasificación específica
        // previamente validada para cada empresa.
        if (
            $override &&
            in_array(
                $override,
                self::SUBCATEGORY_TYPES,
                true
            )
        ) {
            return $override;
        }

        return self::SUBCATEGORY_TYPES[
        $subcategoryId
        ] ?? 'LocalBusiness';
    }

    /**
     * Obtener el mapa completo.
     */
    public static function all(): array
    {
        return self::SUBCATEGORY_TYPES;
    }
}
