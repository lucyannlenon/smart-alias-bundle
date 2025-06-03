# 🧠 SmartAliasBundle

> Gere automaticamente aliases de serviços em tempo de execução com base em atributos no Symfony. Suporte a **singleton** e **array de serviços**, com cache em produção.

[![Tests](https://github.com/lucyannlenon/smart-alias-bundle/actions/workflows/tests.yml/badge.svg)](https://github.com/lucyannlenon/smart-alias-bundle/actions)  
📦 Compatível com Symfony **7.2+**

---

## ⚙️ Instalação

```bash
composer require llenon/smart-alias-bundle
```

Se necessário, adicione o bundle manualmente:

```php
// config/bundles.php
return [
    Llenon\SmartAlias\SmartAliasBundle::class => ['all' => true],
];
```

---

## ✨ Como usar

### `#[SmartAlias]` – singleton obrigatório

Use quando **apenas uma implementação** da interface deve ser registrada. Duplicidades lançarão exceção.

```php
use Llenon\SmartAlias\Attributes\SmartAlias;

#[SmartAlias(ReportProcessorInterface::class)]
class ReportProcessorA implements ReportProcessorInterface
{
    public function process(): void
    {
        // ...
    }
}
```

No seu serviço:

```php
class ReportHandler
{
    public function __construct(private ReportProcessorInterface $processor)
    {
        $this->processor->process();
    }
}
```

---

### `#[SmartAliasMultiple]` – array de serviços

Use quando quiser **injeção múltipla**:

```php
use Llenon\SmartAlias\Attributes\SmartAliasMultiple;

#[SmartAliasMultiple(ReportProcessorInterface::class)]
class ReportProcessorA implements ReportProcessorInterface {}

#[SmartAliasMultiple(ReportProcessorInterface::class)]
class ReportProcessorB implements ReportProcessorInterface {}
```

Injetando múltiplos serviços:

```php
class ReportAggregator
{
    public function __construct(
        /** @var ReportProcessorInterface[] */
        private iterable $processors
    ) {
    }
}
```

---

## 🧪 Testes

```bash
composer test
```

---

## 🔁 Cache & Modo Dev

- Em **produção**, os aliases são cacheados para performance.
- Em **modo dev**, os aliases são atualizados automaticamente em cada requisição.
- Limpe o cache com:

```bash
bin/console cache:clear
```

---

## 🧩 Contribuindo

1. Fork o repositório
2. Crie sua branch (`git checkout -b feature/MinhaFeature`)
3. Commit suas alterações (`git commit -am 'add: nova funcionalidade'`)
4. Push na sua branch (`git push origin feature/MinhaFeature`)
5. Abra um Pull Request

---

## 📝 Licença

MIT © [lucyannlenon](https://github.com/lucyannlenon)
