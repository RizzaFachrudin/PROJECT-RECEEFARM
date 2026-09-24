describe('Logout', () => {


beforeEach(() => {
    cy.login()
})

it('Berhasil logout', () => { 

    cy.contains('Keluar')
        .click()

    cy.get('#logoutModal')
        .should('be.visible')

    cy.get('.btn-logout')
        .click()

    cy.url()
        .should('include', '/sesi')

})


})
