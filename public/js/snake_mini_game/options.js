export function toogleOptionsMenu() {
    const optionsDiv = document.getElementById('options-content');

    if (optionsDiv.style.height == '0vmin') {
        optionsDiv.style.height = '50vmin';
    } else if (optionsDiv.style.height == '50vmin') {
        optionsDiv.style.height = '0vmin';
    }

}
