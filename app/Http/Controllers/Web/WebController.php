<?php

namespace App\Http\Controllers\Web;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Property;
use App\Models\User;
use App\Http\Controllers\Web\FilterController;
use Illuminate\Support\Facades\Mail;
use App\Mail\Web\Contact;

class WebController extends Controller {

    public function home() {
        $head = $this->seo->render(env('APP_NAME'),
                'Encontre o imóvel dos seus sonhos na melhor e mais completa imobiliária do Rio de Janeiro',
                route('web.home'),
                asset('frontend/assets/images/share.png'));
        $propertiesForSale = Property::sale()->available()->orderBy('created_at', 'desc')->limit(12)->get();
        $propertiesForRent = Property::rent()->available()->orderBy('created_at', 'desc')->limit(12)->get();
        return view('web.home', [
            'head' => $head,
            'propertiesForSale' => $propertiesForSale,
            'propertiesForRent' => $propertiesForRent,
        ]);
    }

    public function buy() {
        $head = $this->seo->render(env('APP_NAME') . ' :: Quero Comprar',
                'Compre o imóvel dos seus sonhos na melhor e mais completa imobiliária ddo Rio de Janeiro',
                route('web.buy'),
                asset('frontend/assets/images/share.png'));
        $filter = new FilterController();
        $filter->clearAllData();
        $properties = Property::sale()->available()->orderBy('created_at', 'desc')->get();
        return view('web.filter', [
            'head' => $head,
            'properties' => $properties,
            'type' => 'sale',
        ]);
    }

    public function buyProperty(Request $request) {
        $property = Property::where('slug', $request->slug)->first();
        if ($property) {
            $property->views = $property->views + 1;
            $property->save();
            $propertyOwner = User::where('id', $property->user)->first();
            $head = $this->seo->render(env('APP_NAME') . ' :: Quero Comprar',
                    $property->headline ?? $property->title,
                    route('web.buyProperty', ['slug' => $property->slug]),
                    $property->cover());
            return view('web.property', [
                'head' => $head,
                'property' => $property,
                'type' => 'sale',
                'propertyOwner' => $propertyOwner
            ]);
        } else {
            return redirect()->route('web.home');
        }
    }

    public function rent() {
        $head = $this->seo->render(env('APP_NAME') . ' :: Quero Alugar',
                'Alugue o imóvel dos seus sonhos na melhor e mais completa imobiliária do Rio de Janeiro',
                route('web.rent'),
                asset('frontend/assets/images/share.png'));
        $filter = new FilterController();
        $filter->clearAllData();
        $properties = Property::rent()->available()->orderBy('created_at', 'desc')->get();
        return view('web.filter', [
            'head' => $head,
            'properties' => $properties,
            'type' => 'rent'
        ]);
    }

    public function rentProperty(Request $request) {
        $property = Property::where('slug', $request->slug)->first();
        if ($property) {
            $property->views = $property->views + 1;
            $property->save();
            $propertyOwner = User::where('id', $property->user)->first();
            $head = $this->seo->render(env('APP_NAME') . ' :: Quero Alugar',
                    $property->headline ?? $property->title,
                    route('web.rentProperty', ['slug' => $property->slug]),
                    $property->cover());
            return view('web.property', [
                'head' => $head,
                'property' => $property,
                'type' => 'rent',
                'propertyOwner' => $propertyOwner
            ]);
        } else {
            return redirect()->route('web.home');
        }
    }

    public function filter() {
        $head = $this->seo->render(env('APP_NAME') . ' :: Filtro',
                'Encontre o imóvel dos seus sonhos na melhor e mais completa imobiliária do Rio de Janeiro',
                route('web.filter'),
                asset('frontend/assets/images/share.png'));
        $filter = new FilterController();
        $itemProperties = $filter->createQuery('id');

        foreach ($itemProperties as $property) {
            $properties[] = $property->id;
        }

        if (!empty($properties)) {
            $properties = Property::whereIn('id', $properties)->orderBy('created_at', 'desc')->get();
        } else {
            $properties = Property::all();
        }

        return view('web.filter', [
            'head' => $head,
            'properties' => $properties,
        ]);
    }

    public function experience() {
        $head = $this->seo->render(env('APP_NAME') . ' :: Experiência',
                'Viva a experiência de encontrar o imóvel dos seus sonhos na melhor e mais completa imobiliária do Rio de Janeiro',
                route('web.experience'),
                asset('frontend/assets/images/share.png'));
        $filter = new FilterController();
        $filter->clearAllData();
        $properties = Property::whereNotNull('experience')->get();
        return view('web.filter', [
            'head' => $head,
            'properties' => $properties,
        ]);
    }

    public function experienceCategory(Request $request) {
        $filter = new FilterController();
        $filter->clearAllData();

        if ($request->slug == 'cobertura') {
            $properties = Property::where('experience', 'Cobertura')->where('status', '=', '1')->get();
            $head = $this->seo->render(env('APP_NAME') . ' :: Cobertura',
                    'Viva a experiência de morar na cobertura dos seus sonhos na melhor e mais completa imobiliária do Rio de Janeiro',
                    route('web.experienceCategory', ['slug' => 'cobertura']),
                    asset('frontend/assets/images/share.png'));
        } elseif ($request->slug == 'alto-padrao') {
            $properties = Property::where('experience', 'Alto Padrão')->where('status', '=', '1')->get();
            $head = $this->seo->render(env('APP_NAME') . ' :: Alto Padrão',
                    'Viva a experiência de morar no imóvel de alto padrão dos seus sonhos na melhor e mais completa imobiliária do Rio de Janeiro',
                    route('web.experienceCategory', ['slug' => 'alto-padrao']),
                    asset('frontend/assets/images/share.png'));
        } elseif ($request->slug == 'de-frente-para-o-mar') {
            $properties = Property::where('experience', 'De Frente para o Mar')->where('status', '=', '1')->get();
            $head = $this->seo->render(env('APP_NAME') . ' :: De Frente para o Mar',
                    'Viva a experiência de morar no imóvel de frente para o mar dos seus sonhos na melhor e mais completa imobiliária do Rio de Janeiro',
                    route('web.experienceCategory', ['slug' => 'de-frente-para-o-mar']),
                    asset('frontend/assets/images/share.png'));
        } elseif ($request->slug == 'condominio-fechado') {
            $properties = Property::where('experience', 'Condomínio Fechado')->where('status', '=', '1')->get();
            $head = $this->seo->render(env('APP_NAME') . ' :: Condomínio Fechado',
                    'Viva a experiência de morar no imóvel de condomínio fechado dos seus sonhos na melhor e mais completa imobiliária do Rio de Janeiro',
                    route('web.experienceCategory', ['slug' => 'condominio-fechado']),
                    asset('frontend/assets/images/share.png'));
        } elseif ($request->slug == 'compacto') {
            $properties = Property::where('experience', 'Compacto')->where('status', '=', '1')->get();
            $head = $this->seo->render(env('APP_NAME') . ' :: Compacto',
                    'Viva a experiência de morar no imóvel compacto dos seus sonhos na melhor e mais completa imobiliária do Rio de Janeiro',
                    route('web.experienceCategory', ['slug' => 'compacto']),
                    asset('frontend/assets/images/share.png'));
        } elseif ($request->slug == 'lojas-e-salas') {
            $properties = Property::where('experience', 'Lojas e Salas')->where('status', '=', '1')->get();
            $head = $this->seo->render(env('APP_NAME') . ' :: Lojas e Salas',
                    'Viva a experiência de morar nas lojas e salas dos seus sonhos na melhor e mais completa imobiliária do Rio de Janeiro',
                    route('web.experienceCategory', ['slug' => 'lojas-e-salas']),
                    asset('frontend/assets/images/share.png'));
        } else {
            $properties = Property::whereNotNull('experience')->where('status', '=', '1')->get();
            $head = $this->seo->render(env('APP_NAME') . ' :: Experiência',
                    'Viva a experiência de encontrar o imóvel dos seus sonhos na melhor e mais completa imobiliária do Rio de Janeiro',
                    route('web.experience'),
                    asset('frontend/assets/images/share.png'));
        }
        if (empty($head)) {
            $head = $this->seo->render(env('APP_NAME') . ' :: Experiência',
                    'Viva a experiência de encontrar o imóvel dos seus sonhos na melhor e mais completa imobiliária do Rio de Janeiro',
                    route('web.experience'),
                    asset('frontend/assets/images/share.png'));
        }
        return view('web.filter', [
            'head' => $head,
            'properties' => $properties,
        ]);
    }

    public function spotlight() {
        $head = $this->seo->render(env('APP_NAME') . ' :: Destaque',
                'Confira nossos maiores empreendimentos e lançamentos no Rio de Janeiro!',
                route('web.spotlight'),
                asset('frontend/assets/images/share.png'));
        return view('web.spotlight', [
            'head' => $head
        ]);
    }

    public function contact() {
        $head = $this->seo->render(env('APP_NAME') . ' :: Contato',
                'Quer conversar com um corretor exclusivo e ter o atendimento diferenciado em busca do seu imóvel dos sonhos? '
                . 'Entre em contato com a nossa equipe!',
                route('web.contact'),
                asset('frontend/assets/images/share.png'));
        return view('web.contact', [
            'head' => $head
        ]);
    }

    public function sendEmail(Request $request) {
        if (empty($request['email'])) {
            return redirect()->route('web.home');
        }
        $data = [
            'reply_name' => $request->name,
            'reply_email' => $request->email,
            'cell' => $request->cell,
            'message' => $request->message
        ];

        Mail::send(new Contact($data));

        return redirect()->route('web.sendEmailSuccess');
    }

    public function sendEmailSuccess() {
        $head = $this->seo->render(env('APP_NAME') . ' - E-mail enviado com sucesso!',
                'E-mail enviado com sucesso para a melhor plataforma web do Rio de Janeiro',
                route('web.policy'),
                asset('frontend/assets/images/share.png'));
        return view('web.contact_success', [
            'head' => $head
        ]);
    }

    public function policy() {
        $head = $this->seo->render(env('APP_NAME') . ' :: Política de Pivacidade',
                'Política de Privacidade da melhor plataforma web do Rio de Janeiro!',
                route('web.policy'),
                asset('frontend/assets/images/share.png'));
        return view('web.policy', [
            'head' => $head
        ]);
    }

}
