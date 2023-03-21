//Ouverture jquery
jQuery(document).ready(() => {

    //    (consultant only) Validate job offer
    // $(".jobOffer-switch[type=checkbox]").click( function(){


    // $(".jobOffer-switch").click( function(){
    //     $.ajax({
    //         method: "GET",
    //         url: `/jobOffer/${this.dataset.offer}/validation/${this.dataset.user}`
    //     })
    // })

    // Je ne comprends pas pourquoi mais avec l'URL jobOffer ça n'a jamais marché
    // Alors qu'avec l'URL offer_validation dessous, ça marche, en gardant la même logique
    // $(".jobOffer-switch").click( function(){
    //     $.ajax({
    //         method: "GET",
    //         // url: `/jobOffer/${this.dataset.offer}/validation`
    //         url:`/jobOffer/${this.dataset.offer}/validation`
    //     })
    // })

    $(".jobOffer-switch").click( function(){
        $.ajax({
            method: "GET",
            // url: `/jobOffer/${this.dataset.offer}/validation`
            url:`/offer_validation/${this.dataset.offer}`
        })
    })

    // //    (consultant only) Validate candidature
    // $(".candidature-switch[type=checkbox]").click( function(){
    //     $.ajax({
    //         method: "GET",
    //         url: `/jobOffer/${this.dataset.offer}/validation/${this.dataset.user}`
    //     })
    // })

    //    (candidate only) Apply to job offer
    $(".apply-to-offer").click( function(){
        $.ajax({
            method: "GET",
            url: `/jobOffer/${this.dataset.offer}/postuler/${this.dataset.user}`
        })
            })

    $(".cancel-application").click( function(){
        $.ajax({
            method: "GET",
            url: `/cancel_candidature/${this.dataset.offer}`
        })
    })

// Fermeture jquery
})