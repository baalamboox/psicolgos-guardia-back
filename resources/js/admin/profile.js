const profilePhoto = document?.querySelector('#profilePhoto');
const profile = () => {
    return {
        profilePhotoSource: profilePhoto.dataset.src != '' ? '/' + profilePhoto.dataset.src : '/img/default-profile/default.jpg',
        changeProfilePhoto(event) {
            this.profilePhotoSource = URL.createObjectURL(event.target.files[0]);
        }
    };
};

export { profile };
