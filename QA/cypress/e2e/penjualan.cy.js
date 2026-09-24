describe('Penjualan', () => {

    beforeEach(() => {
        cy.login()
        cy.visit('/penjualan')
    })

    it('Menampilkan halaman penjualan', () => {

        cy.contains('Data Penjualan')
            .should('be.visible')

    })

    it('Menambah data penjualan baru', () => {

        const timestamp = Date.now()

        cy.contains('Tambah Data Penjualan')
            .click()

        cy.url()
            .should('include', '/penjualan/create')

        cy.get('#Nama_Pembeli')
            .type(`Pembeli ${timestamp}`)

        cy.get('#jenis_tanaman')
            .type('Cabai Merah')

        cy.get('#jumlah_pembelian')
            .type('50')

        cy.get('#harga')
            .type('15000')

        cy.get('#tanggal_pembelian')
            .type('2026-06-11')

        cy.contains('Simpan')
            .click()

        cy.url()
            .should('include', '/penjualan')

        cy.contains(`Pembeli ${timestamp}`)
            .should('exist')

    })

    it('Mengubah data penjualan', () => {

        const timestamp = Date.now()

        cy.visit('/penjualan/create')

        cy.get('#Nama_Pembeli')
            .type(`Pembeli Edit ${timestamp}`)

        cy.get('#jenis_tanaman')
            .type('Tomat')

        cy.get('#jumlah_pembelian')
            .type('50')

        cy.get('#harga')
            .type('12000')

        cy.get('#tanggal_pembelian')
            .type('2026-06-11')

        cy.contains('Simpan')
            .click()

        cy.contains(`Pembeli Edit ${timestamp}`)
            .parents('tr')
            .within(() => {

                cy.get('a[href*="/edit"]')
                    .click()

            })

        cy.url()
            .should('include', '/edit')

        cy.get('#Nama_Pembeli')
            .clear()
            .type(`Pembeli Updated ${timestamp}`)

        cy.get('#harga')
            .clear()
            .type('18000')

        cy.get('#jumlah_pembelian')
            .clear()
            .type('50')

        cy.contains('Simpan')
            .click()

        cy.contains(`Pembeli Updated ${timestamp}`)
            .should('exist')

    })

    it('Menghapus data penjualan', () => {

        const timestamp = Date.now()

        cy.visit('/penjualan/create')

        cy.get('#Nama_Pembeli')
            .type(`Pembeli Hapus ${timestamp}`)

        cy.get('#jenis_tanaman')
            .type('Cabai')

        cy.get('#jumlah_pembelian')
            .type('25')

        cy.get('#harga')
            .type('10000')

        cy.get('#tanggal_pembelian')
            .type('2026-06-11')

        cy.contains('Simpan')
            .click()

        cy.on('window:confirm', () => true)

        cy.contains(`Pembeli Hapus ${timestamp}`)
            .parents('tr')
            .within(() => {

                cy.get('.tombol-hapus')
                    .click()

            })

        cy.contains(`Pembeli Hapus ${timestamp}`)
            .should('not.exist')

    })
})

describe('Penjualan - Negative', () => {

    beforeEach(() => {
        cy.login()
        cy.visit('/penjualan')
    })

    it('Menampilkan halaman penjualan', () => {

        cy.contains('Data Penjualan')
            .should('be.visible')

    })

    it('Gagal menambah penjualan jika nama pembeli kosong', () => {

        cy.contains('Tambah Data Penjualan')
        .click()

        cy.get('#jenis_tanaman')
        .type('Cabai')

        cy.get('#jumlah_pembelian')
        .type('10')

        cy.get('#harga')
        .type('5000')

        cy.get('#tanggal_pembelian')
        .type('2026-06-12')

        cy.contains('Simpan')
        .click()

        cy.get('#Nama_Pembeli:invalid')
        .should('exist')
    })

    it('Gagal menambah penjualan jika jumlah pembelian kosong', () => {

        cy.contains('Tambah Data Penjualan')
            .click()

        cy.get('#Nama_Pembeli')
            .type('Budi')

        cy.get('#jenis_tanaman')
            .type('Cabai')

        cy.get('#harga')
            .type('5000')

        cy.get('#tanggal_pembelian')
            .type('2026-06-12')

        cy.contains('Simpan')
            .click()

        cy.get('#jumlah_pembelian:invalid')
            .should('exist')
    })

    it('Gagal menambah penjualan jika jumlah pembelian 0', () => {

        cy.contains('Tambah Data Penjualan')
            .click()

        cy.get('#Nama_Pembeli')
            .type('Budi')

        cy.get('#jenis_tanaman')
            .type('Cabai')

        cy.get('#jumlah_pembelian')
            .type('0')

        cy.get('#harga')
            .type('5000')

        cy.get('#tanggal_pembelian')
            .type('2026-06-12')

        cy.contains('Simpan')
            .click()

        cy.url()
            .should('include', '/create')
    })

    it('Gagal menambah penjualan jika harga negatif', () => {

        cy.contains('Tambah Data Penjualan')
            .click()

        cy.get('#Nama_Pembeli')
            .type('Budi')

        cy.get('#jenis_tanaman')
            .type('Cabai')

        cy.get('#jumlah_pembelian')
            .type('10')

        cy.get('#harga')
            .type('-1000')

        cy.get('#tanggal_pembelian')
            .type('2026-06-12')

        cy.contains('Simpan')
            .click()

        cy.url()
            .should('include', '/create')
    })

    it('Gagal menambah penjualan jika melebihi stok panen', () => {

        cy.contains('Tambah Data Penjualan')
            .click()

        cy.get('#Nama_Pembeli')
            .type('Pembeli Test')

        cy.get('#jenis_tanaman')
            .type('Cabai')

        cy.get('#jumlah_pembelian')
            .type('999999')

        cy.get('#harga')
            .type('5000')

        cy.get('#tanggal_pembelian')
            .type('2026-06-12')

        cy.contains('Simpan')
            .click()

        cy.url()
            .should('include', '/penjualan')
    })
})