INSERT INTO `car` (`id`, `matricule`, `color`, `brand`, `image`, `places`) VALUES
(2, '1234 TVA', 'rouge', 'renault', NULL, 12),
(3, '7717 TAV', 'noir', 'citroen', NULL, 4),
(4, '1211 TAV', 'bleu', 'renault', NULL, 20);


INSERT INTO `client` (`id`, `name`, `birthdate`, `phone_number`, `address`) VALUES
(1, 'Kanto', '2024-02-03', '0233333333', 'paris');


INSERT INTO `reservation` (`id`, `date_reservation`, `duration`, `id_client`, `id_car`, `is_given_back`, `car_state`, `real_return_date`) VALUES
(1, '2024-01-31 01:01:00', 16, 1, 4, 0, NULL, NULL),
(2, '2024-03-10 20:05:00', 1, 1, 2, 0, NULL, NULL),
(3, '2024-03-15 08:00:00', 2, 1, 2, 1, 'bon', '2024-03-14');