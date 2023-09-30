const data = () => {
    const getThemeFromLocalStorage = () => {
        // if user already changed the theme, use it
        if (window.localStorage.getItem('dark')) {
            return JSON.parse(window.localStorage.getItem('dark'))
        }
        // else return their preferences
        return (
            !!window.matchMedia &&
            window.matchMedia('(prefers-color-scheme: dark)').matches
        )
    }
    const setThemeToLocalStorage = (value) => {
        window.localStorage.setItem('dark', value)
    }
    return {
        dark: getThemeFromLocalStorage(),
        toggleTheme() {
            this.dark = !this.dark
            setThemeToLocalStorage(this.dark)
        },
        isSideMenuOpen: false,
        toggleSideMenu() {
            this.isSideMenuOpen = !this.isSideMenuOpen
        },
        closeSideMenu() {
            this.isSideMenuOpen = false
        },
        isNotificationsMenuOpen: false,
        toggleNotificationsMenu() {
            this.isNotificationsMenuOpen = !this.isNotificationsMenuOpen
            console.log(this.isNotificationsMenuOpen)
        },
        closeNotificationsMenu() {
            this.isNotificationsMenuOpen = false
            console.log(this.isNotificationsMenuOpen)
        },
        isProfileMenuOpen: false,
        toggleProfileMenu() {
            this.isProfileMenuOpen = !this.isProfileMenuOpen
        },
        closeProfileMenu() {
            this.isProfileMenuOpen = false
        },
        isPatientsMenuOpen: false,
        togglePatientsMenu() {
            this.isPatientsMenuOpen = !this.isPatientsMenuOpen
        },
        isPsychologistsMenuOpen: false,
        togglePsychologistsMenu() {
            this.isPsychologistsMenuOpen = !this.isPsychologistsMenuOpen
        },
        isShowPassword: 'password',
        textShowPassword: 'Mostrar contraseña',
        toggleShowPassword() {
            if(this.isShowPassword == 'password') {
                this.isShowPassword = 'text'
                this.textShowPassword = 'Ocultar contraseña'
            } else {
                this.isShowPassword = 'password'
                this.textShowPassword = 'Mostrar contraseña'
            }
        },

        // Modal
        isModalOpen: false,
        trapCleanup: null,
        openModal() {
            this.isModalOpen = true
            this.trapCleanup = focusTrap(document.querySelector('#modal'))
        },
        closeModal() {
            this.isModalOpen = false
            this.trapCleanup()
        },
    }
}

export { data };
