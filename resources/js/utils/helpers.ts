/**
 * Méthode appelée pour formater la taille d'un fichier
 * @param size La taille du fichier en octets
 * @returns {string} La taille formatée
 */
export function formatBytes(size: number): string {
    const units: string[] = ['o', 'Ko', 'Mo', 'Go', 'To'];
    let unitIndex: number = 0;

    while (size > 1024) {
        size /= 1024;
        unitIndex++;
    }

    return size.toFixed(2) + ' ' + units[unitIndex];
}
