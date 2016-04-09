<?xml version="1.0"?>
<?mso-application progid="Excel.Sheet"?>
<Workbook xmlns="urn:schemas-microsoft-com:office:spreadsheet"
 xmlns:o="urn:schemas-microsoft-com:office:office"
 xmlns:x="urn:schemas-microsoft-com:office:excel"
 xmlns:ss="urn:schemas-microsoft-com:office:spreadsheet"
 xmlns:html="http://www.w3.org/TR/REC-html40">
<DocumentProperties xmlns="urn:schemas-microsoft-com:office:office">
   <Author>Jackfeng</Author>
   <LastAuthor>Jackfeng</LastAuthor>
  <Created>2010-09-03T18:18:09Z</Created>
  <LastSaved>2010-09-03T18:18:09Z</LastSaved>
  <Version>0.1</Version>
 </DocumentProperties>
 <ExcelWorkbook xmlns="urn:schemas-microsoft-com:office:excel">
  <WindowHeight>12495</WindowHeight>
  <WindowWidth>16035</WindowWidth>
  <WindowTopX>0</WindowTopX>
  <WindowTopY>105</WindowTopY>
  <ProtectStructure>False</ProtectStructure>
  <ProtectWindows>False</ProtectWindows>
 </ExcelWorkbook>
 <Styles>
  <Style ss:ID="Default" ss:Name="Normal">
   <Alignment ss:Vertical="Center"/>
   <Borders/>
   <Font ss:FontName="宋体" x:CharSet="134" ss:Size="12"/>
   <Interior/>
   <NumberFormat/>
   <Protection/>
  </Style>
  <Style ss:ID="s21">
   <Font ss:FontName="宋体" x:CharSet="134" ss:Size="18" ss:Bold="1"/>
  </Style>
  <Style ss:ID="s28">
   <Alignment ss:Vertical="Center"/>
   <Borders>
    <Border ss:Position="Bottom" ss:LineStyle="Continuous" ss:Weight="1"/>
    <Border ss:Position="Left" ss:LineStyle="Continuous" ss:Weight="1"/>
    <Border ss:Position="Right" ss:LineStyle="Continuous" ss:Weight="1"/>
    <Border ss:Position="Top" ss:LineStyle="Continuous" ss:Weight="1"/>
   </Borders>
  </Style>
  <Style ss:ID="s29">
   <Alignment ss:Horizontal="Center" ss:Vertical="Center"/>
   <Borders>
    <Border ss:Position="Bottom" ss:LineStyle="Continuous" ss:Weight="1"/>
    <Border ss:Position="Left" ss:LineStyle="Continuous" ss:Weight="1"/>
    <Border ss:Position="Right" ss:LineStyle="Continuous" ss:Weight="1"/>
    <Border ss:Position="Top" ss:LineStyle="Continuous" ss:Weight="1"/>
   </Borders>
  </Style>
  <Style ss:ID="s35">
   <Alignment ss:Horizontal="Center" ss:Vertical="Center"/>
   <Borders>
    <Border ss:Position="Bottom" ss:LineStyle="Continuous" ss:Weight="1"/>
    <Border ss:Position="Left" ss:LineStyle="Continuous" ss:Weight="1"/>
    <Border ss:Position="Right" ss:LineStyle="Continuous" ss:Weight="1"/>
    <Border ss:Position="Top" ss:LineStyle="Continuous" ss:Weight="1"/>
   </Borders>
   <NumberFormat ss:Format="@"/>
  </Style>
 </Styles>
 <Worksheet ss:Name="<{$title}>">
  <Table x:FullColumns="1" x:FullRows="1" ss:DefaultRowHeight="17.25">
   <{section name=wt loop=$widths}>
       <Column ss:AutoFitWidth="0" ss:Width="<{$widths[wt]}>"/>
   <{/section}>
   <Row ss:Height="22.5">
    <Cell ss:StyleID="s21"><Data ss:Type="String"><{$title}></Data></Cell>
   </Row>
   <Row ss:AutoFitHeight="0">
      <Cell ss:StyleID="s21"><Data ss:Type="String"><{$title2}></Data></Cell>
   </Row>
   <Row ss:AutoFitHeight="0"/>
   <Row ss:AutoFitHeight="0">
    <{section name=hdlist loop=$hd}>
       <Cell ss:StyleID="s29"><Data ss:Type="String"><{$hd[hdlist]}></Data></Cell>
    <{/section}>
   </Row>

   <{* 在这里对要循环输出的数据使用 section 处理。*}>
   <{section name=list loop=$ct}>
   <Row ss:AutoFitHeight="0">
     <{section name=lists loop=$ct[list]}>
       <Cell ss:StyleID="<{$ct[list][lists].StyleID}>"><Data ss:Type="<{$ct[list][lists].Type}>"><{$ct[list][lists].content}></Data></Cell>
     <{/section}>
   </Row>
   <{/section}>

  </Table>
 </Worksheet>
</Workbook>
