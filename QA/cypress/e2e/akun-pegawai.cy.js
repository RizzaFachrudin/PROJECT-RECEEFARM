describe('Kelola Akun Pegawai Positive', () => {

    const timestamp = Date.now()

    const userData = {
        nama: 'Pegawai Testing',
        username: `pegawai${timestamp}`,
        email: `pegawai${timestamp}@test.com`,
        password: 'password'
    }

    beforeEach(() => {
        cy.login()
        cy.visit('/manajemen_akun')
    })

    it('Menampilkan halaman manajemen akun', () => {

        cy.contains('Manajemen Akun')
        cy.get('table').should('exist')

    })

    it('Menambah akun pegawai baru', () => {

        cy.contains('Tambah Akun').click()

        cy.get('#name').type(userData.nama)
        cy.get('#username').type(userData.username)
        cy.get('#password').type(userData.password)
        cy.get('#email').type(userData.email)
        cy.get('#role').select('user')

        cy.contains('Simpan').click()

        cy.contains(userData.username)

    })

    it('Update akun pegawai yang telah dibuat', () => {

        cy.contains('tr', userData.username)
            .find('a.tombol')
            .click()

        cy.url().should('include', '/edit')

        cy.get('#name')
            .clear()
            .type('Pegawai Updated')

        cy.get('#email')
            .clear()
            .type(`updated_${userData.email}`)

        cy.contains('Simpan').click()

        cy.contains('Pegawai Updated')

    })

    it('Menghapus akun pegawai yang telah dibuat', () => {

        cy.on('window:confirm', () => true)

        cy.contains('tr', userData.username)
            .find('.tombol-hapus')
            .click()

        cy.contains(userData.username)
            .should('not.exist')

    })
    
    
})


describe('Kelola Akun Pegawai Negative', () => {
    
    const timestamp = Date.now()
    
    const userData = {
        nama: 'Pegawai Testing',
        username: `pegawai${timestamp}`,
        email: `pegawai${timestamp}@test.com`,
        password: 'password'
    }
    
    beforeEach(() => {
        cy.login()
        cy.visit('/manajemen_akun')
    })

    it('Gagal menambah akun jika username kosong', () => {
    
    cy.contains('Tambah Akun').click()
    
    cy.get('#name')
        .type('Pegawai Testing')
    
    cy.get('#password')
        .type('password')
    
    cy.get('#email')
        .type('pegawai@test.com')
    
    cy.get('#role')
        .select('user')
    
    cy.contains('Simpan').click()
    
    cy.get('#username:invalid')
    .should('exist')
    })


    it('Gagal menambah akun dengan format email salah', () => {

    cy.contains('Tambah Akun').click()

    cy.get('#name')
        .type('Pegawai Testing')

    cy.get('#username')
        .type('pegawai123')

    cy.get('#password')
        .type('password')

    cy.get('#email')
        .type('email-salah')

    cy.get('#role')
        .select('user')

    cy.contains('Simpan').click()

    cy.get('#email:invalid')
        .should('exist')

    })

    it('Gagal menambah akun dengan username yang sudah ada', () => {

    cy.contains('Tambah Akun').click()

    cy.get('#name')
        .type('Admin Clone')

    cy.get('#username')
        .type('admin')

    cy.get('#password')
        .type('password')

    cy.get('#email')
        .type('clone@test.com')

    cy.get('#role')
        .select('user')

    cy.contains('Simpan').click()

    cy.url()
        .should('include', '/create')

    })
})