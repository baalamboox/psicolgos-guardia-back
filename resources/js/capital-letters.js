const capitalLetters = ({ words }) => {
    let capitalizedWords = '';
    words.trim().split(' ').map(
        word => word.charAt(0).toUpperCase() + word.slice(1) != '' ? capitalizedWords += word.charAt(0).toUpperCase() + word.slice(1) + ' ' : false
    );
    return capitalizedWords.trim();
}

export { capitalLetters };
