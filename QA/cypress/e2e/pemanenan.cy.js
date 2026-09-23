describe('Pemanenan', () => {

    beforeEach(() => {
        cy.login()
        cy.visit('/pemanenan')
    })

    it('Menampilkan halaman pemanenan', () => {

        cy.contains('Data Pemanenan')
            .should('be.visible')

    })

    it('Menambah data pemanenan baru', () => {

        const timestamp = Date.now()

        cy.contains('Tambah Data Pemanenan')
            .click()

        cy.url()
            .should('include', '/pemanenan/create')

        cy.get('#jenis_tanaman')
            .type(`Selada`)

        cy.get('#jumlah_panen')
            .type('150')

        cy.get('#tanggal_panen')
            .type('2026-06-11')

        cy.contains('Simpan')
            .click()

        cy.url()
            .should('include', '/pemanenan')

        cy.contains(`Selada`)
            .should('exist')

    })

    it('Mengubah data pemanenan', () => {

        const timestamp = Date.now()

        cy.visit('/pemanenan/create')

        cy.get('#jenis_tanaman')
            .type(`Selada`)

        cy.get('#jumlah_panen')
            .type('100')

        cy.get('#tanggal_panen')
            .type('2026-06-11')

        cy.contains('Simpan')
            .click()

        cy.contains(`Selada`)
            .parents('tr')
            .within(() => {

                cy.get('a[href*="/edit"]')
                    .click()

            })

        cy.url()
            .should('include', '/edit')

        cy.get('#jenis_tanaman')
            .clear()
            .type(`Cabai`)

        cy.get('#jumlah_panen')
            .clear()
            .type('250')

        cy.contains('Simpan Perubahan')
            .click()

        cy.contains(`Cabai`)
            .should('exist')

    })

    it('Menghapus data pemanenan', () => {

        const timestamp = Date.now()

        cy.visit('/pemanenan/create')

        cy.get('#jenis_tanaman')
            .type(`Terong`)

        cy.get('#jumlah_panen')
            .type('75')

        cy.get('#tanggal_panen')
            .type('2026-06-11')

        cy.contains('Simpan')
            .click()

        cy.on('window:confirm', () => true)

        cy.contains(`Terong`)
            .parents('tr')
            .within(() => {

                cy.get('.tombol-hapus')
                    .click()

            })

        cy.contains(`Terong`)
            .should('not.exist')

    })

})