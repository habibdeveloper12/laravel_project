@extends('frontend.layouts.master')
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.6.1/dist/css/bootstrap.min.css">

<style>

</style>
@section('content')
    <style>
        .ord{
            margin-top: 20px;
            margin-bottom: 30px;
            padding: 20px;
            box-shadow: 0 0 1rem 0 rgba(0, 0, 0, .2);
            background-color: rgba(239,239,239,0.72);
            border-radius: 5px;

        }

        @media only screen and (max-width: 991px) {
            .ord{
                margin-top: 25px;
            }
        }
    </style>
    <div class="content">
          <div class="container ord">

              <h2 class="mt-5"> Sellers Terms and Condition</h2>


              <p class="mb-5"> Lorem ipsum dolor sit amet, quo no mucius feugait iracundia, sit et eros putent. At brute doctus laboramus est. Molestie luptatum reprehendunt et his, tota denique his ne. Ad propriae eligendi deseruisse duo, sed cu zril soluta.

                  Nam velit gloriatur no, aeque copiosae evertitur est ne, ad nec wisi mundi suavitate. Vim te alii minim repudiare, eirmod cetero moderatius est ad. Pro ex solet accumsan appareat. Ut mazim rationibus eam. In nonumes alienum sea, ius ei ridens gloriatur, error quodsi per an.

                  Vel vidit justo inermis et. Quot ipsum corrumpit id nec. Vel solet viderer ei, nam harum deserunt accusamus ex, eum sumo consequat ne. Assum denique prodesset duo et.

                  Brute interesset eu vix. Usu an autem aliquando deseruisse, omnium ocurreret has ea, oporteat vulputate cum in. Sadipscing suscipiantur ut mei. Te vis porro tractatos, ei cum unum vituperata. Vide novum audire ad vix.

                  Sea ei solet prodesset. Tota primis no mel, et fuisset dissentiet has, porro movet maiestatis no mea. Consulatu argumentum appellantur sit an. Hinc voluptatibus duo at, eu dolorem consequat adversarium mei. Eu vis nonumes commune nominati, assum dissentiet cu qui. In duo brute labores theophrastus, eum iusto nostrud at, wisi detracto et nec.</p>

              <p>Lorem ipsum dolor sit amet, quo no mucius feugait iracundia, sit et eros putent. At brute doctus laboramus est. Molestie luptatum reprehendunt et his, tota denique his ne. Ad propriae eligendi deseruisse duo, sed cu zril soluta.

                  Nam velit gloriatur no, aeque copiosae evertitur est ne, ad nec wisi mundi suavitate. Vim te alii minim repudiare, eirmod cetero moderatius est ad. Pro ex solet accumsan appareat. Ut mazim rationibus eam. In nonumes alienum sea, ius ei ridens gloriatur, error quodsi per an.

                  Vel vidit justo inermis et.</p>

              <form method="POST" action="{{route('seller.terms')}}">
                  @csrf
                  <input type="hidden" name="user_id" value="{{Auth::user()->user_id}}">
              <button type="submit" class="btn btn-success mb-5"> Accept Terms & condition</button>
              </form>

          </div>
        @endsection
    </div>
