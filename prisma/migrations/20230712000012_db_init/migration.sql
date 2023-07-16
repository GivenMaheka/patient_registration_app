-- CreateTable
CREATE TABLE `Patients` (
    `id` VARCHAR(191) NOT NULL,
    `first_name` VARCHAR(191) NOT NULL,
    `last_name` VARCHAR(191) NOT NULL,
    `birth_date` DATE NOT NULL,
    `gender` VARCHAR(191) NOT NULL,
    `createdAt` DATETIME(3) NOT NULL DEFAULT CURRENT_TIMESTAMP(3),
    `updatedAt` DATETIME(3) NOT NULL,

    PRIMARY KEY (`id`)
) DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci;

-- CreateTable
CREATE TABLE `Visit` (
    `id` VARCHAR(191) NOT NULL,
    `patient_id` VARCHAR(191) NOT NULL,
    `date` DATETIME(3) NOT NULL,
    `height` VARCHAR(191) NOT NULL,
    `weight` VARCHAR(191) NOT NULL,
    `bmi` DECIMAL(65, 30) NOT NULL,

    PRIMARY KEY (`id`)
) DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci;

-- CreateTable
CREATE TABLE `VitalDetails` (
    `id` INTEGER NOT NULL AUTO_INCREMENT,
    `visit_id` VARCHAR(191) NOT NULL,
    `date` DATETIME(3) NOT NULL,
    `health` ENUM('Good', 'Bad') NOT NULL,
    `onDiet` BOOLEAN NOT NULL,
    `onDrugs` BOOLEAN NOT NULL,
    `comments` LONGTEXT NOT NULL,

    PRIMARY KEY (`id`)
) DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci;

-- AddForeignKey
ALTER TABLE `Visit` ADD CONSTRAINT `Visit_patient_id_fkey` FOREIGN KEY (`patient_id`) REFERENCES `Patients`(`id`) ON DELETE RESTRICT ON UPDATE CASCADE;

-- AddForeignKey
ALTER TABLE `VitalDetails` ADD CONSTRAINT `VitalDetails_visit_id_fkey` FOREIGN KEY (`visit_id`) REFERENCES `Visit`(`id`) ON DELETE RESTRICT ON UPDATE CASCADE;
