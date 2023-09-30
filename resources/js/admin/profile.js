const profile = () => {
    return {
        profile_source: 'https://source.unsplash.com/MP0IUfwrn0A',
        change_profile(event) {
            this.profile_source = URL.createObjectURL(event.target.files[0]);
        }
    };
};

export { profile };
